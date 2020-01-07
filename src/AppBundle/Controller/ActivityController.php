<?php

namespace AppBundle\Controller;

use App\Repository\ActivityRepository;
use AppBundle\Constant\ActivityType;
use AppBundle\Entity\Activity;
use AppBundle\Form\Filter\ActivityFilterType;
use AppBundle\Repository\Doctrine\ActivityDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Activity controller.
 *
 * @Route("/admin/activity", name="app_admin_activity_")
 */
class ActivityController extends Controller
{
    /**
     * Lists all activity entities.
     *
     * @Route("/{type}", name="index", requirements={"type" = "activity|evaluation"} )
     * @Method("GET")
     */
    public function indexAction(Request $request, $type, EntityManagerInterface $em, FilterBuilderUpdaterInterface $filterBuilderUpdater)
    {

        $qb =  $em->getRepository(Activity::class)->createQueryBuilder('a')->andWhere('a.type = :type')->setParameter('type', $type);

        $form = $this->get('form.factory')->create(ActivityFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));
            $filterBuilderUpdater->addFilterConditions($form, $qb);

        }

        $pagination = $this->get('knp_paginator')->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('activity/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView()
        ));
    }

    /**
     * Creates a new activity.
     *
     * Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    /*public function newAction(Request $request)
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();

            $this->addFlash('success', 'L\'activité a été ajoutée avec succès.');

            return $this->redirectToRoute('app_admin_activity_index');
        }

        return $this->render('activity/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }*/

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     */
    public function autocomplete(ActivityDoctrineRepository $activityDoctrineRepository, Request $request)
    {
        //todo: refacto with autocomplete material
        $query = $request->query->get('query');

        $activities = $activityDoctrineRepository->findLikeQuery($query);
        $activities = array_map(function($activity){
            return $activity->getLabel();
        }, $activities);


        return $this->json(['query' =>  $query, 'suggestions' => $activities, 'data' => $activities]);
    }

}
