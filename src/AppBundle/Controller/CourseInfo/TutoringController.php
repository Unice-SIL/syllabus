<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseAssistTutoringType;
use AppBundle\Manager\CourseInfoManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TutoringController
 * @package AppBundle\Controller\CourseInfo
 *
 * @Route("/course-info/{id}/tutoring", name="app.course_info.tutoring.")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class TutoringController extends AbstractController
{
    /**
     * @Route("/create", name="create"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseInfoManager $manager
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function addTutoringAction(CourseInfo $courseInfo, CourseInfoManager $manager, Request $request)
    {
        $form = $this->createForm(CourseAssistTutoringType::class, $courseInfo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $courseInfo = $form->getData();
            foreach ($courseInfo->getCourseTutoringResources() as $tutoringResource) {
                $tutoringResource->setPosition($tutoringResource->getPosition() + 1);
            }
            $manager->update($courseInfo);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/prerequisite/form/assist_tutoring.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/{action}", name="active"))
     *
     * @param CourseInfo $courseInfo
     * @param $action
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws Exception
     */
    public function activeTutoringAction(CourseInfo $courseInfo, $action, CourseInfoManager $manager)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $courseInfo->setTutoring($action);
        $manager->update($courseInfo);

        $render = $this->get('twig')->render('course_info/prerequisite/view/tutoring_resources.html.twig', [
            'courseInfo' => $courseInfo
        ]);

        return $this->json([
            'status' => $action,
            'content' => $render
        ]);
    }
}