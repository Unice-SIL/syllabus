<?php

namespace AppBundle\Action;

use AppBundle\Action\ActionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function __construct(Environment $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return new Response($this->templating->render('default/index.html.twig'));
    }
}
