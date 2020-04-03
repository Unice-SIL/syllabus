<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\AskAdvice;
use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\dashboard\AskAdviceType;
use AppBundle\Form\CourseInfo\dashboard\PublishCourseInfoType;
use AppBundle\Form\CourseInfo\DuplicateCourseInfoType;
use AppBundle\Helper\Report\Report;
use AppBundle\Manager\CourseInfoManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/", name="index")
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $courseInfoManager
     * @param EntityManagerInterface $em
     * @return Response
     * @throws \Exception
     */
    public function indexAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $courseInfoManager, EntityManagerInterface $em)
    {

        $duplicationForm = $this->createForm(DuplicateCourseInfoType::class);
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

                    $this->addFlash('success', 'La duplication a été réalisée avec succès');
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
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function dashboardViewAction(CourseInfo $courseInfo, ValidatorInterface $validator)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $validationsGroups = ['presentation', 'contentActivities', 'objectives', 'evaluation', 'equipment', 'info', 'closingRemark'];
        $violations = [];
        foreach ($validationsGroups as $validationsGroup) {
            $violations[$validationsGroup] = $validator->validate($courseInfo, null, $validationsGroup);
        }

        $render = $this->get('twig')->render('course_info/dashboard/view/dashboard.html.twig', [
            'courseInfo' => $courseInfo,
            'violations' => $violations,
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
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @throws \Exception
     * @Route("/publish", name="pusblish", methods={"POST"} )
     */
    public function publishCourseInfo(CourseInfo $courseInfo, Request $request, EntityManagerInterface $em) {

        $publishForm = $this->createForm(PublishCourseInfoType::class, $courseInfo);
        $publishForm->handleRequest($request);

        if ($publishForm->isSubmitted() and $publishForm->isValid()) {
            $isPublished = $publishForm->all()['publish']->getData();

            $courseInfo->setPublicationDate($isPublished ? new \DateTime() : null);

            $em->flush();

            return $this->json(['error' => false]);
        }

        return $this->json(['error' => true]);
    }
}