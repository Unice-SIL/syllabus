<?php

namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Factory\ImportCourseTeacherFactory;
use AppBundle\Form\CourseInfo\Presentation\GeneralType;
use AppBundle\Form\CourseInfo\Presentation\RemoveTeacherType;
use AppBundle\Form\CourseInfo\Presentation\SynopsisType;
use AppBundle\Form\CourseInfo\Presentation\TeachersType;
use AppBundle\Form\CourseInfo\Presentation\TeachingModeType;
use AppBundle\Manager\CourseInfoManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseInfoPresentationController
 * @package AppBundle\Controller
 */
class CourseInfoPresentationController extends AbstractController
{
    /**
     * @Route("/course/{id}/presentation", name="course_presentation")
     *
     * @param CourseInfo $courseInfo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(CourseInfo $courseInfo)
    {
        return $this->render('course_info/presentation/presentation.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/course/{id}/presentation/general/view", name="course_presentation_general_view"))
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function generalViewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        $render = $this->get('twig')->render('course_info/presentation/view/general.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/presentation/general/form", name="course_presentation_general_form"))
     *
     * @param $id
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function generalFormAction($id, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        $form = $this->createForm(GeneralType::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseInfo->checkMedia();
            $manager->update($courseInfo);
            $render = $this->get('twig')->render('course_info/presentation/view/general.html.twig', [
                'courseInfo' => $courseInfo
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }

        $render = $this->get('twig')->render('course_info/presentation/form/general.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/presentation/teachers/view", name="course_presentation_teachers_view"))
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function teachersViewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        $render = $this->get('twig')->render('course_info/presentation/view/teachers.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/presentation/teachers/form", name="course_presentation_teachers_form"))
     *
     * @param $id
     * @param Request $request
     * @param CourseInfoManager $manager
     * @param ImportCourseTeacherFactory $factory
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addTeachersAction($id, Request $request, CourseInfoManager $manager, ImportCourseTeacherFactory $factory)
    {
        $status = true;
        $message = null;

        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        $teacher = new CourseTeacher();

        $form = $this->createForm(TeachersType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid())
            {
                /** @var CourseTeacher $data */
                $data = $form->getData();
                $login = $form->get('login')->getData();
                $source = $form->get('teacherSource')->getData();
                $courseTeacher = $factory->getFindByIdQuery($source)->setId($login)->execute();
                $courseTeacher->setManager($data->isManager())
                    ->setEmailVisibility($data->isEmailVisibility())
                    ->setCourseInfo($courseInfo);
                $courseInfo->addCourseTeacher($courseTeacher);
                $manager->update($courseInfo);
            }
            else
            {
                $status = false;
                $message = ['type' => 'none'];
            }
        }

        $render = $this->get('twig')->render('course_info/presentation/form/teachers.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => $status,
            'content' => $render,
            'message' => $message
        ]);
    }

    /**
     * @Route("/course/{id}/presentation/teachers/delete/{teacherId}", name="course_presentation_remove_teacher"))
     *
     * @param $id
     * @param $teacherId
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteTeacherAction($id, $teacherId, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);


        /** @var CourseTeacher $teacher */
        $teacher = $em->getRepository(CourseTeacher::class)->find($teacherId);

        if (!$teacher instanceof CourseTeacher)
        {
            return $this->json([
                'status' => false,
                'content' => "L'enseignant {$teacherId} n'existe pas"
            ]);
        }

        $form = $this->createForm(RemoveTeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var CourseTeacher $teacher */
            $teacher = $form->getData();
            $courseInfo->removeCourseTeacher($teacher);
            $manager->update($courseInfo);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/presentation/form/remove_teacher.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/presentation/teaching_mode/view", name="course_presentation_teaching_mode_view"))
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function teachingModeViewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        $render = $this->get('twig')->render('course_info/presentation/view/teaching_mode.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/presentation/teaching_mode/form", name="course_presentation_teaching_mode_form"))
     *
     * @param $id
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function teachingModeFormAction($id, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        $form = $this->createForm(TeachingModeType::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($courseInfo);
            $render = $this->get('twig')->render('course_info/presentation/view/teaching_mode.html.twig', [
                'courseInfo' => $courseInfo
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }
        $render = $this->get('twig')->render('course_info/presentation/form/teaching_mode.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/teachers/select2/list", name="teachers_select2_list")
     *
     * @param Request $request
     * @param ImportCourseTeacherFactory $factory
     * @return JsonResponse
     * @throws \Exception
     */
    public function listUsersFromExternalRepositoryAction(Request $request, ImportCourseTeacherFactory $factory)
    {
        $courseTeachersArray = [];
        $term = $request->query->get('q');
        $source = $request->query->get('source');
        //$source = 'ldap_uns';
        $courseTeachers = $factory->getSearchQuery($source)->setTerm($term)->execute();
        foreach ($courseTeachers as $courseTeacher){
            $courseTeachersArray[] = [
                'id' => $courseTeacher->getId(),
                'text' => $courseTeacher->getLastname().' '.$courseTeacher->getFirstname().' ('.$courseTeacher->getEmail().')'
            ];
        }
        return new JsonResponse($courseTeachersArray);
    }
}