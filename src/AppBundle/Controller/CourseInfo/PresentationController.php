<?php

namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Factory\ImportCourseTeacherFactory;
use AppBundle\Form\CourseInfo\Presentation\GeneralType;
use AppBundle\Form\CourseInfo\Presentation\TeachersType;
use AppBundle\Form\CourseInfo\Presentation\TeachingModeType;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CourseTeacherManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class PresentationController
 * @package AppBundle\Controller\CourseInfo
 * @Route("/course-info/{id}/presentation", name="app.course_info.presentation.")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class PresentationController extends AbstractController
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
     * @Route("/general", name="general"))
     *
     * @param CourseInfo|null $courseInfo
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generalViewAction(?CourseInfo $courseInfo, TranslatorInterface $translator)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_course')
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
     * @Route("/general/edit", name="general.edit"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generalFormAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager, TranslatorInterface $translator)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_course')
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
     * @Route("/teachers", name="teachers"))
     *
     * @param CourseInfo $courseInfo
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function teachersViewAction(CourseInfo $courseInfo, TranslatorInterface $translator)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_course')
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
     * @Route("/teachers/add", name="teachers.add"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseTeacherManager $courseTeacherManager
     * @param ImportCourseTeacherFactory $factory
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addTeachersAction(CourseInfo $courseInfo, Request $request, CourseTeacherManager $courseTeacherManager,
                                      ImportCourseTeacherFactory $factory, TranslatorInterface $translator)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_course')
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
     * @Route("/teaching-mode", name="teaching_mode"))
     *
     * @param CourseInfo $courseInfo
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function teachingModeViewAction(CourseInfo $courseInfo, TranslatorInterface $translator)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_course')
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
     * @Route("/teaching-mode/edit", name="teaching_mode.edit"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function teachingModeFormAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager, TranslatorInterface $translator)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_course')
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