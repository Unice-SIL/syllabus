<?php


namespace AppBundle\Controller\Admin;


use AppBundle\Entity\AskAdvice;
use AppBundle\Form\DashboardType;
use AppBundle\Manager\StatisticSyllabusManager;
use AppBundle\Manager\YearManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package AppBundle\Controller
 *
 * @Route("/dashboard", name="app_admin.dashboard_")
 */
class DashboardController extends AbstractController
{

    /**
     * @Route("/",name="index", methods={"POST", "GET"})
     *
     * @param Request $request
     * @param StatisticSyllabusManager $statisticSyllabusManager
     * @param YearManager $yearManager
     * @return Response
     * @throws \Exception
     */
    public function IndexAction(Request $request, StatisticSyllabusManager $statisticSyllabusManager, YearManager $yearManager)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(DashboardType::class);
        $form->handleRequest($request);

        $repoAskDevice = $em->getRepository(AskAdvice::class);

        $totalAskAdvices = $repoAskDevice->createQueryBuilder('a')
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