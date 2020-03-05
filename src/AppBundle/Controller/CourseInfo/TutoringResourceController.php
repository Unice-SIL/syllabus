<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTutoringResource;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseTutoringResourcesType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCourseTutoringResourcesType;
use AppBundle\Manager\CourseTutoringResourceManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TutoringResourceController
 * @package AppBundle\Controller\CourseInfo
 *
 * @Route("/course-info/tutoring-resource/{id}", name="app.course_info.tutoring_resource.")
 */
class TutoringResourceController extends AbstractController
{
    /**
     * @Route("/create", name="create"))
     * @Security("is_granted('WRITE', courseInfo)")
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseTutoringResourceManager $courseTutoringResourceManager
     * @return Response
     */
    public function addTutoringResourceAction(CourseInfo $courseInfo, Request $request, CourseTutoringResourceManager $courseTutoringResourceManager)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $tutoringResource = $courseTutoringResourceManager->new();
        $tutoringResource->setCourseInfo($courseInfo);
        $form = $this->createForm(CourseTutoringResourcesType::class, $tutoringResource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseTutoringResourceManager->create($tutoringResource);

            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/tutoring_resources.html.twig', [
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
     * @Security("is_granted('WRITE', tutoringResources)")
     *
     * @param CourseTutoringResource $tutoringResources
     * @param Request $request
     * @param CourseTutoringResourceManager $courseTutoringResourceManager
     * @return JsonResponse
     */
    public function editTutoringResourceAction(CourseTutoringResource $tutoringResources,
                                               Request $request, CourseTutoringResourceManager $courseTutoringResourceManager)
    {
        $form = $this->createForm(CourseTutoringResourcesType::class, $tutoringResources);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseTutoringResourceManager->update($tutoringResources);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/edit_tutoring_resources.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/delete", name="delete"))
     * @Security("is_granted('WRITE', tutoringResources)")
     *
     * @param CourseTutoringResource $tutoringResource
     * @param Request $request
     * @param CourseTutoringResourceManager $courseTutoringResourceManager
     * @return JsonResponse
     */
    public function deleteTutoringResourcesAction(CourseTutoringResource $tutoringResource, Request $request,
                                                  CourseTutoringResourceManager $courseTutoringResourceManager)
    {
        if (!$tutoringResource instanceof CourseTutoringResource) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : la remédiation n'existe pas"
            ]);
        }
        $form = $this->createForm(RemoveCourseTutoringResourcesType::class, $tutoringResource);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $courseTutoringResourceManager->delete($tutoringResource);

            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/objectives_course/form/remove_tutoring_resources.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}