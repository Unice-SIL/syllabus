<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Form\CourseInfo\CourseAchievement\CoursePrerequisiteType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCoursePrerequisiteType;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CoursePrerequisiteManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PrerequisiteController
 * @package AppBundle\Controller\CourseInfo
 *
 * @Route("/course-info/prerequisite/{id}", name="app.course_info.prerequisite.")
 */
class PrerequisiteController extends AbstractController
{
    /**
     * @Route("/create", name="create"))
     * @Security("is_granted('WRITE', courseInfo)")
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return Response
     * @throws Exception
     */
    public function addPrerequisiteAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $prerequisite = new CoursePrerequisite();
        $form = $this->createForm(CoursePrerequisiteType::class, $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prerequisite = $form->getData();
            $courseInfo->addCoursePrerequisite($prerequisite);
            foreach ($courseInfo->getCoursePrerequisites() as $prerequisite) {
                $prerequisite->setPosition($prerequisite->getPosition() + 1);
            }
            $manager->update($courseInfo);

            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/prerequisite.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/edit", name="edit"))
     * @Security("is_granted('WRITE', prerequisite)")
     *
     * @param CoursePrerequisite $prerequisite
     * @param Request $request
     * @param CoursePrerequisiteManager $coursePrerequisiteManager
     * @return JsonResponse
     */
    public function editPrerequisiteAction(CoursePrerequisite $prerequisite, Request $request,
                                           CoursePrerequisiteManager $coursePrerequisiteManager)
    {
        $form = $this->createForm(CoursePrerequisiteType::class, $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursePrerequisiteManager->update($prerequisite);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/edit_prerequisite.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/delete", name="delete"))
     * @Security("is_granted('WRITE', prerequisite)")
     *
     * @param CoursePrerequisite $prerequisite
     * @param Request $request
     * @param CoursePrerequisiteManager $coursePrerequisiteManager
     * @return JsonResponse
     */
    public function deletePrerequisitesAction(CoursePrerequisite $prerequisite, Request $request,
                                              CoursePrerequisiteManager $coursePrerequisiteManager)
    {
        if (!$prerequisite instanceof CoursePrerequisite) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : le prérequis n'existe pas"
            ]);
        }
        $form = $this->createForm(RemoveCoursePrerequisiteType::class, $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursePrerequisiteManager->delete($prerequisite);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/objectives_course/form/remove_prerequisite.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}