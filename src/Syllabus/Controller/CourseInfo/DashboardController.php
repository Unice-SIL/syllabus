<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\AskAdvice;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Form\CourseInfo\dashboard\AskAdviceType;
use App\Syllabus\Form\CourseInfo\dashboard\PublishCourseInfoType;
use App\Syllabus\Form\CourseInfo\DuplicateCourseInfoType;
use App\Syllabus\Helper\MailHelper;
use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Manager\CourseInfoManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DashboardController
 * @package AppBundle\Controller\CourseInfo
 *
 * @Route("/course-info/{id}/dashboard", name="app.course_info.dashboard.")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class DashboardController extends AbstractController
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * DashboardController constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @Route("/", name="index")
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $courseInfoManager
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @return Response
     * @throws \Exception
     */
    public function indexAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $courseInfoManager,
                                EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $duplicationForm = $this->createForm(DuplicateCourseInfoType::class, ['currentCourseInfo' => $courseInfo->getId()]);
        $duplicationForm->handleRequest($request);

        $isFormValid = true;
        if ($duplicationForm->isSubmitted()) {

            if ($duplicationForm->isValid()) {
                $data = $duplicationForm->getData();
                $from = $data['from'];

                /** @var  CourseInfo $to */
                $to = $data['to']->getCodeYear(true);

                /** @var Report $report */
                $report = $courseInfoManager->duplicate($from, $to, CourseInfoManager::DUPLICATION_CONTEXTE_MANUALLY);

                if (!$report->hasMessages() and !$report->hasLines()) {

                    $this->addFlash('success', $translator->trans('app.controller.dashboard.duplication_success'));
                    $em->flush();

                    return $this->redirectToRoute('app.course_info.dashboard.index', ['id' => $courseInfo->getId()]);
                }

                foreach ($report->getMessages() as $message) {
                    $this->addFlash($message->getType(), $message->getContent());
                }

                foreach ($report->getLines() as $line) {
                    foreach ($line->getComments() as $comment) {
                        $this->addFlash('danger', $comment);
                    }
                }

                return $this->redirectToRoute('app.course_info.dashboard.index', ['id' => $courseInfo->getId()]);
            }
            $isFormValid = false;
        }

        return $this->render('course_info/dashboard/dashboard.html.twig', [
            'courseInfo' => $courseInfo,
            'duplicationForm' => $duplicationForm->createView(),
            'isFormValid' => $isFormValid,
        ]);
    }

    /**
     * @Route("/dashboard", name="dashboard"))
     *
     * @param CourseInfo $courseInfo
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function dashboardViewAction(CourseInfo $courseInfo, TranslatorInterface $translator)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => $translator->trans('app.controller.error.empty_course')
            ]);
        }

        /** @var Validation $violations */
        $violations = $this->getViolation($courseInfo);

        // pourcentage violations
        $countViolation = 0;
        foreach ($violations as $violation)
        {
            if ($violation->count() === 0){
                $countViolation +=1;
            }
        }
        $violationPourcentage = ($countViolation/count($violations)) * 100;
        $render = $this->get('twig')->render('course_info/dashboard/view/dashboard.html.twig', [
            'courseInfo' => $courseInfo,
            'violations' => $violations,
            'violationPourcentage' => round($violationPourcentage),
            'publicationForm' => $this->createForm(PublishCourseInfoType::class, $courseInfo)->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render,
        ]);
    }

    /**
     * @Route("/askAdvice", name="askAdvice"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @return JsonResponse
     */
    public function AskAdvice(CourseInfo $courseInfo, Request $request)
    {
        $askAdvice = new AskAdvice();
        $askAdvice->setUser($this->getUser())->setCourseInfo($courseInfo);
        $form = $this->createForm(AskAdviceType::class, $askAdvice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($askAdvice);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/dashboard/form/ask_advice.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $courseInfoManager
     * @param TranslatorInterface $translator
     * @return JsonResponse
     * @Route("/publish", name="publish", methods={"POST"} )
     */
    public function publishCourseInfo(CourseInfo $courseInfo, Request $request, CourseInfoManager $courseInfoManager, TranslatorInterface $translator, MailHelper $mailHelper)
    {
        $publishForm = $this->createForm(PublishCourseInfoType::class, $courseInfo);
        $publishForm->handleRequest($request);

        if (!$publishForm->isSubmitted() or !$publishForm->isValid())
        {
            return $this->json(['status'=>false, 'message'=>$translator->trans('app.dashboard.message.publication.failed')]);
        };

        /** @var CourseInfo $courseInfo */
        $courseInfo = $publishForm->getData();

        if(!empty($courseInfo->getPublicationDate()))
        {
            return $this->json(['status'=>false, 'message'=>$translator->trans('app.dashboard.message.publication.already_publish')]);
        }

        $violationsGroups = $this->getViolation($courseInfo);
        /** @var ConstraintViolationList $violationsGroup */
        foreach ($violationsGroups as $violationsGroup)
        {
            if($violationsGroup->count() > 0) return $this->json(['status'=>false, 'message'=>$translator->trans('app.dashboard.message.publication.cannot_published')]);
        }

        $courseInfo->setPublisher($this->getUser())
            ->setPublicationDate(new \DateTime());

        $courseInfoManager->update($courseInfo);

        $mailHelper->sendNewSyllabusPublishedMessage($courseInfo, $this->getUser());

        return $this->json(['status'=>true, 'message'=>$translator->trans('app.dashboard.message.publication.success')]);

    }

    /**
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $courseInfoManager
     * @return JsonResponse
     * @Route("/publish-next-year", name="publishNextYear", methods={"POST"} )
     */
    public function DuplicateCourseInfoNextYear(CourseInfo $courseInfo, Request $request, CourseInfoManager $courseInfoManager)
    {
        $courseInfo->setDuplicateNextYear($request->get('action'));
        $courseInfoManager->update($courseInfo);
        return $this->json(['status' => true]);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return array
     */
    private function getViolation(CourseInfo $courseInfo)
    {
        $validationsGroups = ['presentation', 'prerequisites', 'contentActivities', 'objectives', 'evaluation',
            'equipment', 'info', 'closingRemark'];
        $violations = [];
        foreach ($validationsGroups as $validationsGroup) {
            $violations[$validationsGroup] = $this->validator->validate($courseInfo, null, $validationsGroup);
        }
        return $violations;
    }
}