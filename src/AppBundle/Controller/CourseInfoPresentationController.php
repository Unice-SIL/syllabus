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
use AppBundle\Manager\CourseTeacherManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseInfoPresentationController
 * @package AppBundle\Controller
 * @Route("/course/{id}/presentation", name="course_presentation_")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class CourseInfoPresentationController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param CourseInfo $courseInfo
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function indexAction(CourseInfo $courseInfo)
    {
        return $this->render('course_info/presentation/presentation.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/general/view", name="general_view"))
     *
     * @param CourseInfo|null $courseInfo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generalViewAction(?CourseInfo $courseInfo)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : Le cours n'existe pas"
            ]);
        }

        $render = $this->get('twig')->render('course_info/presentation/view/general.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/general/form", name="general_form"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function generalFormAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : Le cours n'existe pas"
            ]);
        }

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
     * @Route("/teachers/view", name="teachers_view"))
     *
     * @param CourseInfo $courseInfo
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function teachersViewAction(CourseInfo $courseInfo)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : Le cours n'existe pas"
            ]);
        }

        $teachers = $courseInfo->getCourseTeachers()->toArray();
        setlocale(LC_ALL, "fr_FR.utf8");
        usort($teachers, function ($a, $b) {
            return strcoll($a->getLastname(), $b->getLastname());
        });

        $render = $this->get('twig')->render('course_info/presentation/view/teachers.html.twig', [
            'courseInfo' => $courseInfo,
            'teachers' => $teachers
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/teachers/form", name="teachers_form"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseTeacherManager $courseTeacherManager
     * @param ImportCourseTeacherFactory $factory
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addTeachersAction(CourseInfo $courseInfo, Request $request, CourseTeacherManager $courseTeacherManager, ImportCourseTeacherFactory $factory)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : Le cours n'existe pas"
            ]);
        }

        $status = true;
        $message = null;
        $teacher = $courseTeacherManager->new();

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
                $courseTeacherManager->create($courseTeacher);
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
     * @Route("/teachers/remove/{teacherId}", name="remove_teacher"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseTeacher $teacher
     * @param Request $request
     * @param CourseTeacherManager $courseTeacherManager
     * @return JsonResponse
     * @ParamConverter("teacher", options={"mapping": {"teacherId": "id"}})
     */
    public function removeTeacherAction(CourseInfo $courseInfo, CourseTeacher $teacher, Request $request, CourseTeacherManager $courseTeacherManager)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : Le cours n'existe pas"
            ]);
        }

        if (!$teacher instanceof CourseTeacher)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : L'enseignant n'existe pas"
            ]);
        }

        $form = $this->createForm(RemoveTeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $courseTeacherManager->delete($teacher);
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
     * @Route("/teaching_mode/view", name="teaching_mode_view"))
     *
     * @param CourseInfo $courseInfo
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function teachingModeViewAction(CourseInfo $courseInfo)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : Le cours n'existe pas"
            ]);
        }

        $render = $this->get('twig')->render('course_info/presentation/view/teaching_mode.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/teaching_mode/form", name="teaching_mode_form"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function teachingModeFormAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : Le cours n'existe pas"
            ]);
        }
        
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
}