<?php

namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CourseTeacher;
use App\Syllabus\Factory\ImportCourseTeacherFactory;
use App\Syllabus\Form\CourseInfo\Presentation\GeneralType;
use App\Syllabus\Form\CourseInfo\Presentation\TeachersType;
use App\Syllabus\Form\CourseInfo\Presentation\TeachingModeType;
use App\Syllabus\Manager\CourseInfoManager;
use App\Syllabus\Manager\CourseTeacherManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class PresentationController
 * @package App\Syllabus\Controller\CourseInfo
 * @Route("/course-info/{id}/presentation", name="app.course_info.presentation.")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class PresentationController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param CourseInfo $courseInfo
     * @return Response
     * @throws Exception
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
     * @return Response
     */
    public function generalViewAction(?CourseInfo $courseInfo, Environment $twig)
    {
        $render = $twig->render('course_info/presentation/view/general.html.twig', [
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
     * @param Environment $twig
     * @return Response
     */
    public function generalFormAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager, Environment $twig)
    {
        $form = $this->createForm(GeneralType::class, $courseInfo, ['media' => $courseInfo->getMediaType()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseInfo->checkMedia();
            $manager->update($courseInfo);
            $render = $twig->render('course_info/presentation/view/general.html.twig', [
                'courseInfo' => $courseInfo
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }

        $render = $twig->render('course_info/presentation/form/general.html.twig', [
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
     * @param Environment $twig )
     * @return Response
     */
    public function teachersViewAction(CourseInfo $courseInfo, Environment $twig)
    {
        $teachers = $courseInfo->getCourseTeachers()->toArray();
        setlocale(LC_ALL, "fr_FR.utf8");
        usort($teachers, function ($a, $b) {
            return strcoll($a->getLastname(), $b->getLastname());
        });

        $render = $twig->render('course_info/presentation/view/teachers.html.twig', [
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
     * @param Environment $twig )
     * @return Response
     * @throws Exception
     */
    public function addTeachersAction(CourseInfo                 $courseInfo,
                                      Request                    $request,
                                      CourseTeacherManager       $courseTeacherManager,
                                      ImportCourseTeacherFactory $factory,
                                      Environment                $twig
    )
    {
        $status = true;
        $message = null;
        $teacher = $courseTeacherManager->new();

        $form = $this->createForm(TeachersType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                /** @var CourseTeacher $data */
                $data = $form->getData();
                $login = $form->get('login')->getData();
                $source = $form->get('teacherSource')->getData();
                $courseTeacher = $factory->getFindByIdQuery($source)->setId($login)->execute();
                $courseTeacher->setManager($data->isManager())
                    ->setEmailVisibility($data->isEmailVisibility())
                    ->setCourseInfo($courseInfo);
                $courseTeacherManager->create($courseTeacher);
            } else {
                $status = false;
                $message = ['type' => 'none'];
            }
        }

        $render = $twig->render('course_info/presentation/form/teachers.html.twig', [
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
     * @param Environment $twig )
     * @return Response
     */
    public function teachingModeViewAction(CourseInfo $courseInfo, Environment $twig)
    {
        $render = $twig->render('course_info/presentation/view/teaching_mode.html.twig', [
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
     * @param Environment $twig
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function teachingModeFormAction(
        CourseInfo  $courseInfo,
        Request $request,
        CourseInfoManager $manager,
        Environment $twig
    ): Response
    {
        $form = $this->createForm(TeachingModeType::class, $courseInfo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($courseInfo);
            $render = $twig->render('course_info/presentation/view/teaching_mode.html.twig', [
                'courseInfo' => $courseInfo
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }

        $render = $twig->render('course_info/presentation/form/teaching_mode.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}