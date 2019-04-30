<?php

namespace AppBundle\Action;

use AppBundle\Action\ActionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


/**
 * Class HomeAction
 * @package AppBundle\Action
 */
class HomeAction implements ActionInterface
{

    /**
     * @var Environment
     */
    private $templating;

    /**
     * HomeAction constructor.
     * @param Environment $templating
     */
    public function __construct(
            SessionInterface $session,
            Environment $templating
        )
    {

        $this->session = $session;
        $this->templating = $templating;
    }

    /**
     * @Route("/", name="homepage", methods={"GET"})
     * @return Response
     */
    public function __invoke(Request $request)
    {

        return new Response($this->templating->render('default/index.html.twig'));
    }
}
