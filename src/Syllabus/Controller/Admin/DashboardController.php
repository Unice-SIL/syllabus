<?php


namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Entity\AskAdvice;
use App\Syllabus\Form\DashboardType;
use App\Syllabus\Manager\StatisticSyllabusManager;
use App\Syllabus\Manager\YearManager;
use App\Syllabus\Repository\Doctrine\AskAdviceDoctrineRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Syllabus\Controller
 *
 * @Route("/dashboard", name="app.admin.dashboard.")
 */
class DashboardController extends AbstractController
{

    /**
     * @Route("/",name="index", methods={"POST", "GET"})
     *
     * @param Request $request
     * @param StatisticSyllabusManager $statisticSyllabusManager
     * @param YearManager $yearManager
     * @param AskAdviceDoctrineRepository $adviceDoctrineRepository
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function IndexAction(
        Request $request,
        StatisticSyllabusManager $statisticSyllabusManager,
        YearManager $yearManager,
        AskAdviceDoctrineRepository $adviceDoctrineRepository
    ): Response
    {
        $form = $this->createForm(DashboardType::class);
        $form->handleRequest($request);

        $totalAskAdvices = $adviceDoctrineRepository->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.process = 0')
            ->getQuery()
            ->getSingleScalarResult();

        $currentYear = $yearManager->findCurrentYear()->getId();
        $syllabusPublished = count($statisticSyllabusManager->findSyllabusPublished($currentYear));
        $syllabusBeingFilled = count($statisticSyllabusManager->findSyllabusBeingFilled($currentYear));
        $years = $yearManager->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $syllabusPublished = count($statisticSyllabusManager->findSyllabusPublished($form->getData()['years']->getId()));
            $syllabusBeingFilled = count($statisticSyllabusManager->findSyllabusBeingFilled($form->getData()['years']->getId()));
        }

        return $this->render('dashboard/index.html.twig', array(
                'askAdviceCount' => $totalAskAdvices,
                'syllabusPublished' => $syllabusPublished,
                'syllabusBeingFilled' => $syllabusBeingFilled,
                'years' => $years,
                'form' => $form->createView(),
            )
        );
    }
}