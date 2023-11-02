<?php


namespace App\Syllabus\Controller;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CoursePermission;
use App\Syllabus\Entity\User;
use App\Syllabus\Entity\Year;
use App\Syllabus\Form\Filter\MySyllabusFilterType;
use App\Syllabus\Form\SearchSyllabusType;
use App\Syllabus\Manager\YearManager;
use App\Syllabus\Repository\Doctrine\CourseDoctrineRepository;
use App\Syllabus\Repository\Doctrine\CourseInfoDoctrineRepository;
use App\Syllabus\Repository\Doctrine\CoursePermissionDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Syllabus\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/course/router/{code}/{year}", name="app_router", defaults={"year"=null})
     * @param $code
     * @param CourseInfoDoctrineRepository $repository
     * @param YearManager $yearManager
     * @param string|null $year
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function routerAction($code,
                                 CourseInfoDoctrineRepository $repository,
                                 YearManager $yearManager,
                                 string $year = null,
                                 EntityManagerInterface $em
    )
    {
        if (empty($year)) {
            $year = $yearManager->findCurrentYear();
        }
        /** @var CourseInfo $courseInfo */
        $courseInfo = $repository->findByCodeAndYear($code, $year);
        if (empty($courseInfo)) {
            return $this->render('error/courseNotFound.html.twig');
        }
        $permissions = $em->getRepository(CoursePermission::class)->findBy([
            'user' => $this->getUser(),
            'courseInfo' => $courseInfo
        ]);
        if (count($permissions) > 0 || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app.course_info.dashboard.index', ['id' => $courseInfo->getId()]);
        }
        return $this->redirectToRoute('app.course_info.view.student', ['id' => $courseInfo->getId()]);
    }

    /**
     * @Route("/course/router-light/{code}/{year}", name="app_router_anon", defaults={"year"=null})
     * @param $code
     * @param $year
     * @param CourseInfoDoctrineRepository $repository
     * @param YearManager $yearManager
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function routerLightAction($code, $year, CourseInfoDoctrineRepository $repository, YearManager $yearManager)
    {

        if (empty($year)) {
            $year = $yearManager->findCurrentYear();
            if (!$year instanceof Year) {
                throw new NotFoundHttpException('Year not found');
            }
            $year = $year->getId();
        }

        /** @var CourseInfo $courseInfo */
        $courseInfo = $repository->findByCodeAndYear($code, $year);
        if (!$courseInfo instanceof CourseInfo) {
            return $this->render('error/courseNotFound.html.twig');
        }

        if (!$this->getUser()) {
            return $this->redirectToRoute('app.course_info.view.light_version', ['id' => $courseInfo->getId()]);
        }

        return $this->redirectToRoute('app_router', ['code' => $code, 'year' => $year]);
    }

    /**
     * @Route("/courses", name="app_index")
     * @param Request $request
     * @param CoursePermissionDoctrineRepository $coursePermissionRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function indexAction(
        Request $request,
        CoursePermissionDoctrineRepository $coursePermissionRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater,
        PaginatorInterface $paginator
    ): Response
    {

        /** @var User $user */
        $user = $this->getUser();
        $page = $request->query->getInt('page', 1);

        $formCourses = $this->createForm(SearchSyllabusType::class);
        $form = $this->createForm(MySyllabusFilterType::class, null);
        $qb = $coursePermissionRepository->getCourseByPermissionQueryBuilder($user);

        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));
            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $courses = $paginator->paginate($qb, $page, 10);

        return $this->render('default/homepage.html.twig', [
            'courses' => $courses,
            'form' => $form->createView(),
            'formCourses' => $formCourses->createView()
        ]);
    }

    /**
     * @Route("/search-courses", name="app.search_courses")
     * @param Request $request
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @return Response
     */
    public function searchCourses(Request $request, CourseInfoDoctrineRepository $courseInfoDoctrineRepository): Response
    {
        $courseInfosList = [];
        $form = $this->createForm(SearchSyllabusType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $courseInfosList = $courseInfoDoctrineRepository->findByTitleOrCodeForCurrentYear($search);

            return $this->render('default/search_courses.html.twig', [
                'form' => $form->createView(),
                'courseInfosList' => $courseInfosList,
                'isSubmit' => true
            ]);
        }

        return $this->render('default/search_courses.html.twig', [
            'form' => $form->createView(),
            'courseInfosList' => $courseInfosList,
            'isSubmit' => false
        ]);
    }

    /**
     * @Route("/credits", name="credits")
     */
    public function creditsAction()
    {
        return $this->render('default/credits.html.twig');
    }
}