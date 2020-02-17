<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Equipment;
use AppBundle\Form\EquipmentType;
use AppBundle\Form\Filter\EquipmentFilterType;
use AppBundle\Manager\EquipmentManager;
use AppBundle\Repository\Doctrine\EquipmentDoctrineRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EquipmentController
 * @package AppBundle\Controller
 *
 * @Route("/admin/equipment", name="app_admin_equipment_")
 */
class EquipmentController extends Controller
{
    /**
     * @Route("/", name="index")
     *
     * @param Request $request
     * @param EquipmentDoctrineRepository $equipmentDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        EquipmentDoctrineRepository $equipmentDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {

        $qb = $equipmentDoctrineRepository->getIndexQueryBuilder();

        $form = $this->createForm(EquipmentFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));
            $filterBuilderUpdater->addFilterConditions($form, $qb);

        }

        $pagination = $this->get('knp_paginator')->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('equipment/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new equipment.
     *
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param EquipmentManager $equipmentManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request, EquipmentManager $equipmentManager)
    {
        $equipment = $equipmentManager->create();
        $form = $this->createForm(EquipmentType::class, $equipment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'L\'équipement a été ajouté avec succès.');

            return $this->redirectToRoute('app_admin_equipment_index');
        }

        return $this->render('equipment/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipment entity.
     *
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Equipment $equipment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Equipment $equipment)
    {
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'L\'équipement a été modifié avec succès.');

            return $this->redirectToRoute('app_admin_equipment_edit', array('id' => $equipment->getId()));
        }

        return $this->render('equipment/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "label"})
     *
     * @param EquipmentDoctrineRepository $equipmentDoctrineRepository
     * @param Request $request
     * @param $field
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function autocomplete(EquipmentDoctrineRepository $equipmentDoctrineRepository, Request $request, $field)
    {
        $query = $request->query->get('query');

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $equipments = $equipmentDoctrineRepository->findLikeQuery($query, $field);

        $equipments = array_map(function($equipment) use ($field, $propertyAccessor){
            return $propertyAccessor->getValue($equipment, $field);
        }, $equipments);

        $equipments = array_unique($equipments);

        return $this->json(['query' =>  $query, 'suggestions' => $equipments, 'data' => $equipments]);
    }

}
