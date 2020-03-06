<?php

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\ActivityMode;
use AppBundle\Form\ActivityModeType;
use AppBundle\Form\Filter\ActivityModeFilterType;
use AppBundle\Manager\ActivityModeManager;
use AppBundle\Repository\Doctrine\ActivityModeDoctrineRepository;
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
 * Class ActivityModeController
 * @package AppBundle\Controller
 *
 * @Route("/admin/activity-mode", name="app.admin.activity_mode.")
 * @Security("has_role('ROLE_ADMIN_ACTIVITYMODE')")
 */
class ActivityModeController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @Security("has_role('ROLE_ADMIN_ACTIVITYMODE_LIST')")
     * @param Request $request
     * @param ActivityModeDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        ActivityModeDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {
        $qb =  $repository->getIndexQueryBuilder();

        $form = $this->createForm(ActivityModeFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('activity_mode/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_ACTIVITYMODE_CREATE')")
     *
     * @param Request $request
     * @param ActivityModeManager $activityTypeManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, ActivityModeManager $activityTypeManager)
    {
        $activityMode = $activityTypeManager->new();
        $form = $this->createForm(ActivityModeType::class, $activityMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $activityTypeManager->create($activityMode);

            $this->addFlash('success', 'Le mode d\'activité a été ajoutée avec succès.');

            return $this->redirectToRoute('app.admin.activity_mode.index');
        }

        return $this->render('activity_mode/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_ACTIVITYMODE_UPDATE')")
     *
     * @param Request $request
     * @param ActivityMode $activityMode
     * @param ActivityModeManager $activityModeManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, ActivityMode $activityMode, ActivityModeManager $activityModeManager)
    {
        $form = $this->createForm(ActivityModeType::class, $activityMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $activityModeManager->update($activityMode);

            $this->addFlash('success', 'Le mode d\'activité a été modifiée avec succès.');

            return $this->redirectToRoute('app.admin.activity_mode.edit', array('id' => $activityMode->getId()));
        }

        return $this->render('activity_mode/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     * @param ActivityModeDoctrineRepository $repository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocomplete(ActivityModeDoctrineRepository $repository, Request $request)
    {
        $query = $request->query->get('query');

        $activitiesModes = $repository->findLikeQuery($query);
        $activitiesModes = array_map(function($mode){
            return $mode->getLabel();
        }, $activitiesModes);

        $activitiesModes = array_unique($activitiesModes);
        $activitiesModes = array_values($activitiesModes);

        return $this->json(['query' =>  $query, 'suggestions' => $activitiesModes, 'data' => $activitiesModes]);
    }
}