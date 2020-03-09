<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\ActivityType;
use AppBundle\Form\ActivityTypeType;
use AppBundle\Form\Filter\ActivityTypeFilterType;
use AppBundle\Manager\ActivityTypeManager;
use AppBundle\Repository\Doctrine\ActivityTypeDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActivityTypeController
 * @package AppBundle\Controller
 *
 * @Route("/admin/activity-type", name="app.admin.activity_type.")
 * @Security("has_role('ROLE_ADMIN_ACTIVITYTYPE')")
 */
class ActivityTypeController extends AbstractController
{

    /**
     * @Route("/", name="index", methods={"GET"})
     * @Security("has_role('ROLE_ADMIN_ACTIVITYTYPE_LIST')")
     * @param Request $request
     * @param ActivityTypeDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        ActivityTypeDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {
        $qb =  $repository->getIndexQueryBuilder();

        $form = $this->createForm(ActivityTypeFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('activity_type/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new activity.
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_ACTIVITYTYPE_CREATE')")
     * @param Request $request
     * @param ActivityTypeManager $activityTypeManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, ActivityTypeManager $activityTypeManager)
    {
        $activityType = $activityTypeManager->new();
        $form = $this->createForm(ActivityTypeType::class, $activityType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activityTypeManager->create($activityType);

            $this->addFlash('success', 'Le type d\'activité a été ajoutée avec succès.');

            return $this->redirectToRoute('app.admin.activity_type.index');
        }

        return $this->render('activity_type/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_ACTIVITYTYPE_UPDATE')")
     * @param Request $request
     * @param ActivityType $activityType
     * @param ActivityTypeManager $activityTypeManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, ActivityType $activityType, ActivityTypeManager $activityTypeManager)
    {
        $form = $this->createForm(ActivityTypeType::class, $activityType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $activityTypeManager->update($activityType);

            $this->addFlash('success', 'L\'activité a été modifiée avec succès.');

            return $this->redirectToRoute('app.admin.activity_type.edit', array('id' => $activityType->getId()));
        }

        return $this->render('activity_type/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     * @param ActivityTypeDoctrineRepository $repository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocomplete(ActivityTypeDoctrineRepository $repository, Request $request)
    {
        $query = $request->query->get('query');

        $activitieTypes = $repository->findLikeQuery($query, $request->query->get('field'));
        $activitieTypes = array_map(function($activityType){
            return $activityType->getLabel();
        }, $activitieTypes);

        $activitieTypes = array_unique($activitieTypes);
        $activitieTypes = array_values($activitieTypes);

        return $this->json(['query' =>  $query, 'suggestions' => $activitieTypes, 'data' => $activitieTypes]);
    }

}
