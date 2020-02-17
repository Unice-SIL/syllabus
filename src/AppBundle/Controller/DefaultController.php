<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\User;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CoursePermissionRepositoryInterface;
use AppBundle\Repository\YearRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/course/router/{code}/{year}", name="app_router", defaults={"year"=null})
     * @param $code
     * @param string $year
     * @param CourseInfoRepositoryInterface $repository
     * @param YearRepositoryInterface $yearRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function routerAction($code, $year, CourseInfoRepositoryInterface $repository, YearRepositoryInterface $yearRepository)
    {
        if (empty($year)) {
            $year = $yearRepository->findCurrentYear();
        }
        /** @var CourseInfo $courseInfo */
        $courseInfo = $repository->findByCodeAndYear($code, $year);
        if (empty($courseInfo)) {
            return $this->render('error/courseNotFound.html.twig');
        }
        return $this->redirectToRoute('course_dashboard_index', ['id' => $courseInfo->getId()]);
    }

    /**
     * @Route("/courses", name="app_index")
     * @param CoursePermissionRepositoryInterface $coursePermissionRepository
     * @return Response
     */
    public function indexAction(CoursePermissionRepositoryInterface $coursePermissionRepository)
    {
        /** @var User $user */
        $user = $this->getUser();
        $courseInfos = $coursePermissionRepository->getCourseBypermission($user);
        $courseInfosByYear = [];
        foreach ($courseInfos as $courseInfo )
        {
           $courseInfosByYear[$courseInfo->getYear()->getId()][] = $courseInfo;
        }

        return $this->render('default/homepage.html.twig', array(
            'courses' => $courseInfosByYear));
    }
}