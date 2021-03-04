<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseTutoringResource;
use App\Syllabus\Form\CourseInfo\CourseAchievement\CourseTutoringResourcesType;
use App\Syllabus\Form\CourseInfo\CourseAchievement\RemoveCourseTutoringResourcesType;
use App\Syllabus\Manager\CourseTutoringResourceManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class TutoringResourceController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Route("/course-info/tutoring-resource/{id}", name="app.course_info.tutoring_resource.")
 * @Security("is_granted('WRITE', tutoringResources)")
 */
class TutoringResourceController extends AbstractController
{
    /**
     * @Route("/edit", name="edit"))
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

        $render = $this->get('twig')->render('course_info/prerequisite/form/edit_tutoring_resources.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/delete", name="delete"))
     *
     * @param CourseTutoringResource $tutoringResources
     * @param Request $request
     * @param CourseTutoringResourceManager $courseTutoringResourceManager
     * @param TranslatorInterface $translator
     * @return JsonResponse
     */
    public function deleteTutoringResourcesAction(CourseTutoringResource $tutoringResources, Request $request,
                                                  CourseTutoringResourceManager $courseTutoringResourceManager, TranslatorInterface $translator)
    {
        if (!$tutoringResources instanceof CourseTutoringResource) {
            return $this->json([
                'status' => false,
                'content' => $translator->trans('app.controller.error.empty_course')
            ]);
        }
        $form = $this->createForm(RemoveCourseTutoringResourcesType::class, $tutoringResources);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $courseTutoringResourceManager->delete($tutoringResources);

            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/prerequisite/form/remove_tutoring_resources.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}