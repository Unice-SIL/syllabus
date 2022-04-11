<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Form\CourseInfo\CourseAchievement\CourseAssistTutoringType;
use App\Syllabus\Manager\CourseInfoManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class TutoringController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Route("/course-info/{id}/tutoring", name="app.course_info.tutoring.")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class TutoringController extends AbstractController
{
    /**
     * @Route("/create", name="create"))
     * @param CourseInfo $courseInfo
     * @param CourseInfoManager $manager
     * @param Request $request
     * @param Environment $environment
     * @return JsonResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function addTutoringAction(
        CourseInfo $courseInfo,
        CourseInfoManager $manager,
        Request $request,
        Environment $environment
    ): JsonResponse
    {
        $form = $this->createForm(CourseAssistTutoringType::class, $courseInfo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /*
            foreach ($courseInfo->getCourseTutoringResources() as $tutoringResource) {
                $tutoringResource->setPosition($tutoringResource->getPosition() + 1);
            }
            */
            $manager->update($courseInfo);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $environment->render('course_info/prerequisite/form/assist_tutoring.html.twig', [
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
     * @param CourseInfo $courseInfo
     * @param $action
     * @param CourseInfoManager $manager
     * @param Environment $environment
     * @return JsonResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function activeTutoringAction(
        CourseInfo $courseInfo,
        $action,
        CourseInfoManager $manager,
        Environment $environment
    ): JsonResponse
    {
        $courseInfo->setTutoring($action);
        $manager->update($courseInfo);

        $render = $environment->render('course_info/prerequisite/view/tutoring_resources.html.twig', [
            'courseInfo' => $courseInfo
        ]);

        return $this->json([
            'status' => $action,
            'content' => $render
        ]);
    }
}