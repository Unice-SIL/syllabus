<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CoursePrerequisite;
use App\Syllabus\Form\CourseInfo\CourseAchievement\CoursePrerequisiteType;
use App\Syllabus\Form\CourseInfo\CourseAchievement\CourseTutoringResourcesType;
use App\Syllabus\Manager\CourseInfoManager;
use App\Syllabus\Manager\CourseTutoringResourceManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CoursePrerequisite
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Security("is_granted('WRITE', courseInfo)")
 */
#[Route(path: '/course-info/{id}/prerequisite', name: 'app.course_info.prerequisite.')]
class CoursePrerequisiteController extends AbstractController
{
    
    #[Route(path: '/', name: 'index')]
    public function indexAction(CourseInfo $courseInfo): Response
    {
        return $this->render('course_info/prerequisite/prerequisite.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/prerequisites', name: 'prerequisites')]
    public function prerequisiteViewAction(CourseInfo $courseInfo, Environment $twig): Response
    {
        $render = $twig->render('course_info/prerequisite/view/prerequisite.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/prerequisite/add', name: 'add')]
    public function addPrerequisiteAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager, Environment $twig): Response
    {
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

        $render = $twig->render('course_info/prerequisite/form/prerequisite.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route(path: '/prerequisite/sort', name: 'prerequisite.sort')]
    public function sortPrerequisitesAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager): JsonResponse
    {
        $prerequisites = $courseInfo->getCoursePrerequisites();
        $dataPrerequisites = $request->request->all('data');

        $this->sortList($courseInfo, $prerequisites, $dataPrerequisites, $manager);

        return $this->json([
            'status' => true,
            'content' => null
        ]);
    }

    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/tutoring-resources', name: 'tutoring_resources')]
    public function tutoringResourcesViewAction(CourseInfo $courseInfo, Environment $twig): Response
    {
        $render = $twig->render('course_info/prerequisite/view/tutoring_resources.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/tutoring-resource/add', name: 'tutoring_resource.add')]
    public function addTutoringResourceAction(CourseInfo                    $courseInfo, Request $request,
                                              CourseTutoringResourceManager $courseTutoringResourceManager,
                                              Environment                   $twig): Response
    {
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

        $render = $twig->render('course_info/prerequisite/form/tutoring_resources.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route(path: '/tutoring-resources/sort', name: 'sort_tutoring_resources')]
    public function sortTutoringResourcesAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager): JsonResponse
    {
        $tutoringResources = $courseInfo->getCourseTutoringResources();
        $dataTutoringResources = $request->request->all('data');

   //     dd($dataTutoringResources);
        $this->sortList($courseInfo, $tutoringResources, $dataTutoringResources, $manager);

        return $this->json([
            'status' => true,
            'content' => null
        ]);
    }

    /**
     * @param $courseInfoList
     * @param $data
     * @throws Exception
     */
    private function sortList(CourseInfo $courseInfo, $courseInfoList, $data, CourseInfoManager $manager): void
    {
        if ($data) {
            foreach ($courseInfoList as $item) {
                if (in_array($item->getId(), $data)) {

                    $item->setPosition(array_search($item->getId(), $data));
                }
            }
            $manager->update($courseInfo);
        }
    }
}