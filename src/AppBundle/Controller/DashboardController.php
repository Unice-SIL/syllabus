<?php


namespace AppBundle\Controller;


use AppBundle\Entity\AskAdvice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package AppBundle\Controller
 *
 * @Route("/admin/dashboard", name="app_admin.dashboard_")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/",name="index", methods={"GET"})
     *
     * @param Request $request
     * @return Response
     */
    public function IndexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repoAskDevice = $em->getRepository(AskAdvice::class);

        $totalAskAdvices = $repoAskDevice->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.process = 0')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('dashboard/index.html.twig', array(
                'askAdviceCount' => $totalAskAdvices
            )
        );
    }
}