<?php

namespace AppBundle\Controller;

use AppBundle\Form\Filter\EquipmentFilterType;
use AppBundle\Repository\Doctrine\EquipmentDoctrineRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;

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
