<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class MaintenanceController
 * @package AppBundle\Controller
 * @Route("/mainteance", name ="app.maintenance.")
 */
class MaintenanceController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function indexAction()
    {
        return $this->render('maintenance/index.html.twig');
    }
}