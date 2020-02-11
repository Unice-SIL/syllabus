<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\YearRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RouterController extends AbstractController
{
    /**
     * @Route("/course/router/{etbId}/{year}", name="app_router", defaults={"year"=null})
     * @param $etbId
     * @param string $year
     * @param CourseInfoRepositoryInterface $repository
     * @param YearRepositoryInterface $yearRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction($etbId, $year, CourseInfoRepositoryInterface $repository, YearRepositoryInterface $yearRepository)
    {
        if (empty($year)) {
            $year = $yearRepository->findCurrentYear();
        }
        /** @var CourseInfo $courseInfo */
        $courseInfo = $repository->findByEtbIdAndYear($etbId, $year);
        if(empty($courseInfo)){
            return $this->render('error/courseNotFound.html.twig');
        }
        return $this->redirectToRoute('course_dashboard_index', ['id' => $courseInfo->getId()]);
    }
}