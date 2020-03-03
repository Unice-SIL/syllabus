<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Year;
use AppBundle\Form\YearType;
use AppBundle\Manager\YearManager;
use AppBundle\Repository\Doctrine\YearDoctrineRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Year controller.
 *
 * @Route("/admin/year", name="app_admin.year_")
 * @Security("has_role('ROLE_ADMIN_YEAR')")
 */
class YearController extends Controller
{
    /**
     * Lists all year entities.
     *
     * @Route("/", name="index", methods={"GET"})
     *
     * @Security("has_role('ROLE_ADMIN_YEAR_LIST')")
     * @param Request $request
     * @return Response
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
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_YEAR_CREATE')")
     * @param Request $request
     * @param YearManager $yearManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, YearManager $yearManager)
    {
        $year = $yearManager->new();

        $form = $this->createForm(YearType::class, $year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yearManager->create($year);
            $this->addFlash('success', 'L\'année a été ajoutée avec succès.');

            return $this->redirectToRoute('app_admin.year_index');
        }

        return $this->render('year/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing year entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_YEAR_UPDATE')")
     * @param Request $request
     * @param Year $year
     * @param YearManager $yearManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Year $year, YearManager $yearManager)
    {
        $form = $this->createForm('AppBundle\Form\YearType', $year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $yearManager->update($year);

            $this->addFlash('success', 'L\'année a été modifiée avec succès.');

            return $this->redirectToRoute('app_admin.year_edit', array('id' => $year->getId()));
        }

        return $this->render('year/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocompleteS2", name="autocompleteS2", methods={"GET"})
     * @param YearDoctrineRepository $yearDoctrineRepository
     * @param Request $request
     * @return JsonResponse
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
