<?php


namespace AppBundle\Controller;


use AppBundle\Entity\ActivityType;
use AppBundle\Repository\Doctrine\ActivityTypeDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActivityTypeController
 * @package AppBundle\Controller
 *
 * @Route("/admin/type_activity", name="app_admin_type_activity_")
 */
class ActivityTypeController extends Controller
{

    /**
     * @param Request $request
     * @param ActivityTypeDoctrineRepository $activityTypeDoctrineRepository
     *
     * @Route("/",name="index" )
     * @Method("GET")
     * @return Response
     */
    public function IndexAction(Request $request, ActivityTypeDoctrineRepository $activityTypeDoctrineRepository)
    {
        $qb = $activityTypeDoctrineRepository->getIndexQueryBuilder();

        $pagination = $this->get('knp_paginator')->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('activity_type/index.html.twig', array(
            'pagination' => $pagination
        ));
    }

}