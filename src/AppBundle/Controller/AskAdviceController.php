<?php


namespace AppBundle\Controller;


use AppBundle\Manager\AskAdviceManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AskAdviceController
 * @package AppBundle\Controller
 *
 * @Route("/admin/campus", name="app_admin_ask_advice_")
 */
class AskAdviceController extends AbstractController
{
    /**
     * Lists all activity entities.
     *
     * @Route("/", name="index", methods={"GET"})
     * @param Request $request
     * @param AskAdviceManager $adviceManager
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, AskAdviceManager $adviceManager, PaginatorInterface $paginator)
    {
        $pagination = $paginator->paginate(
            $adviceManager->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('ask_advice/index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/{id}/view", name="view", methods={"GET"})
     *
     *
     */
    public function viewAction()
    {

    }

}