<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePermission;
use AppBundle\Entity\User;
use AppBundle\Manager\YearManager;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use AppBundle\Repository\Doctrine\CoursePermissionDoctrineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @param CourseInfoDoctrineRepository $repository
     * @param YearManager $yearManager
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function routerAction($code, $year, CourseInfoDoctrineRepository $repository, YearManager $yearManager)
    {
        if (empty($year)) {
            $year = $yearManager->findCurrentYear();
        }
        /** @var CourseInfo $courseInfo */
        $courseInfo = $repository->findByCodeAndYear($code, $year);
        if (empty($courseInfo)) {
            return $this->render('error/courseNotFound.html.twig');
        }
        $permissions = $this->getDoctrine()->getRepository(CoursePermission::class)->findBy([
            'user' => $this->getUser(),
            'courseInfo' => $courseInfo
        ]);
        if(count($permissions)>0 || $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app.course_info.dashboard.index', ['id' => $courseInfo->getId()]);
        }
        return $this->redirectToRoute('app.course_info.view.student', ['id' => $courseInfo->getId()]);
    }

    /**
     * @Route("/courses", name="app_index")
     * @param CoursePermissionDoctrineRepository $coursePermissionRepository
     * @return Response
     */
    public function indexAction(CoursePermissionDoctrineRepository $coursePermissionRepository)
    {
        /** @var User $user */
        $user = $this->getUser();
        $courseInfos = $coursePermissionRepository->getCourseByPermission($user);
        $courseInfosByYear = [];
        foreach ($courseInfos as $courseInfo )
        {
           $courseInfosByYear[$courseInfo->getYear()->getId()][] = $courseInfo;
        }

        return $this->render('default/homepage.html.twig', array(
            'courses' => $courseInfosByYear));
    }
}