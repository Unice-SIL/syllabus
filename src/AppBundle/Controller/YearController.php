<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Year;
use AppBundle\Form\YearType;
use AppBundle\Manager\YearManager;
use AppBundle\Repository\Doctrine\YearDoctrineRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Year controller.
 *
 * @Route("/admin/year", name="app_admin_year_")
 */
class YearController extends Controller
{
    /**
     * Lists all year entities.
     *
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $pagination = $this->get('knp_paginator')->paginate(
            $this->getDoctrine()->getManager()->createQuery("SELECT y FROM AppBundle:Year y"),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('year/index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new year entity.
     *
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, YearManager $yearManager)
    {
        $year = $yearManager->create();

        $form = $this->createForm(YearType::class, $year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($year);
            $em->flush();

            $this->addFlash('success', 'L\'année a été ajoutée avec succès.');

            return $this->redirectToRoute('app_admin_year_index');
        }

        return $this->render('year/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing year entity.
     *
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Year $year, YearManager $yearManager)
    {
        $form = $this->createForm('AppBundle\Form\YearType', $year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $yearManager->update($year);

            $this->getDoctrine()->getManager()->flush();


            $this->addFlash('success', 'L\'année a été modifiée avec succès.');

            return $this->redirectToRoute('app_admin_year_edit', array('id' => $year->getId()));
        }

        return $this->render('year/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocompleteS2", name="autocompleteS2", methods={"GET"})
     * @param YearDoctrineRepository $yearDoctrineRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function autocompleteS2(YearDoctrineRepository $yearDoctrineRepository, Request $request)
    {
        $query = $request->query->get('q');

        $years = $yearDoctrineRepository->findLikeQuery($query, 'y.label');

        $data = array_map(function ($y) use ($request) {
            return ['id' => $y->getId(), 'text' => $y->getLabel()];
        }, $years);

        return $this->json($data);
    }
}
