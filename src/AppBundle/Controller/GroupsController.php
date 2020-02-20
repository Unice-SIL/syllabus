<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Groups;
use AppBundle\Form\Filter\GroupsFilterType;
use AppBundle\Form\GroupsType;
use AppBundle\Repository\Doctrine\GroupsDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

        $deleteFormsView = [];

        foreach ($pagination as $group) {
            $deleteFormsView[$group->getId()] = $this->createDeleteForm($group)->createView();
        }

        return $this->render('groups/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
            'deleteFormsView' => $deleteFormsView
        ));
    }

    /**
     * Creates a new groups entity.
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $group = new Groups();

        $form = $this->createForm(GroupsType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            $this->addFlash('success', 'Le groupe a été ajouté avec succès.');

            return $this->redirectToRoute('app_admin_groups_index');
        }

        return $this->render('groups/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing groups entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     *
     */
    public function editAction(Request $request, Groups $groups, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(GroupsType::class, $groups);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();


            $this->addFlash('success', 'Le groups a été modifié avec succès.');

            return $this->redirectToRoute('app_admin_groups_edit', array('id' => $groups->getId()));
        }

        return $this->render('groups/edit.html.twig', array(
            'form' => $form->createView(),
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

    /**
     * Deletes a groups entity.
     *
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Groups $group
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Groups $group)
    {
        $form = $this->createDeleteForm($group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();
        }

        return $this->redirectToRoute('app_admin_groups_index');
    }

    /**
     * Creates a form to delete a groups entity.
     *
     * @param Groups $group The group entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Groups $group)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app_admin_groups_delete', array('id' => $group->getId())))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, [
                'label' => 'Supprimer',
                'attr' => [
                    'class' => 'btn btn-danger float-right'
                ]
            ])
            ->getForm()
            ;
    }
}