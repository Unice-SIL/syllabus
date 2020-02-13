<?php


namespace AppBundle\Controller;


use AppBundle\Form\Filter\GroupsFilterType;
use AppBundle\Repository\Doctrine\GroupsDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GroupsController
 * @package AppBundle\Controller
 * @Route("/admin/groups", name="app_admin_groups_")
 */
class GroupsController extends Controller
{
    /**
     * Lists all groups entities.
     *
     * @Route("/", name="index", methods={"GET"})
     */
    public function indexAction(
        Request $request,
        GroupsDoctrineRepository $groupsDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {

        $qb = $groupsDoctrineRepository->getIndexQueryBuilder();

        $form = $this->createForm(GroupsFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));
            $filterBuilderUpdater->addFilterConditions($form, $qb);

        }

        $pagination = $this->get('knp_paginator')->paginate(
            $qb,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('groups/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "label"})
     *
     * @param GroupsDoctrineRepository $groupsDoctrineRepository
     * @param Request $request
     * @param $field
     * @return JsonResponse
     */
    public function autocomplete(GroupsDoctrineRepository $groupsDoctrineRepository, Request $request, $field)
    {
        $query = $request->query->get('query');

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $groups = $groupsDoctrineRepository->findLikeQuery($query, $field);

        $groups = array_map(function($group) use ($field, $propertyAccessor){
            return $propertyAccessor->getValue($group, $field);
        }, $groups);

        $groups = array_unique($groups);

        return $this->json(['query' =>  $query, 'suggestions' => $groups, 'data' => $groups]);
    }
}