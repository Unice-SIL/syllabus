<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Structure;
use AppBundle\Form\Filter\StructureFilterType;
use AppBundle\Form\StructureType;
use AppBundle\Repository\Doctrine\StructureDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class StructureController
 * @package AppBundle\Controller
 *
 * @Route("/admin/structure", name="app_admin_structure_")
 */
class StructureController extends Controller
{


    /**
     * @Route("/", name="index")
     *
     * @param Request $request
     * @param StructureDoctrineRepository $structureDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        StructureDoctrineRepository $structureDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {

        $qb = $structureDoctrineRepository->getIndexQueryBuilder();

        $form = $this->createForm(StructureFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));
            $filterBuilderUpdater->addFilterConditions($form, $qb);

        }

        $pagination = $this->get('knp_paginator')->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('structure/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing structure entity.
     *
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     *
     */
    public function editAction(Request $request, Structure $structure, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();


            $this->addFlash('success', 'La strucutre a été modifiée avec succès.');

            return $this->redirectToRoute('app_admin_structure_edit', array('id' => $structure->getId()));
        }

        return $this->render('structure/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "etbId|label|campus"})
     *
     * @param StructureDoctrineRepository $structureDoctrineRepository
     * @param Request $request
     * @param $field
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function autocomplete(StructureDoctrineRepository $structureDoctrineRepository, Request $request, $field)
    {
        $query = $request->query->get('query');

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $structures = $structureDoctrineRepository->findLikeQuery($query, $field);

        $structures = array_map(function($structure) use ($field, $propertyAccessor){
            return $propertyAccessor->getValue($structure, $field);
        }, $structures);

        $structures = array_unique($structures);

        return $this->json(['query' =>  $query, 'suggestions' => $structures, 'data' => $structures]);
    }
}
