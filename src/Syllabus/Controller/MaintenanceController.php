<?php


namespace App\Syllabus\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class MaintenanceController
 * @package App\Syllabus\Controller
 * @Route("/maintenance", name ="app.maintenance.")
 */
class MaintenanceController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function indexAction(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('maintenance/index.html.twig');
    }
}