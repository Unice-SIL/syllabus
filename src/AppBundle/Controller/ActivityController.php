<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Activity;
use AppBundle\Form\ActivityType;
use AppBundle\Form\Filter\ActivityFilterType;
use AppBundle\Manager\ActivityManager;
use AppBundle\Repository\Doctrine\ActivityDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Activity controller.
 *
 * @Route("/admin/activity", name="app_admin_activity_")
 */
class ActivityController extends AbstractController
{
    /**
     * Lists all activity entities.
     *
     * @Route("/", name="index", methods={"GET"})
     * @param Request $request
     * @param ActivityDoctrineRepository $repository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function indexAction(Request $request, ActivityDoctrineRepository $repository,
                                FilterBuilderUpdaterInterface $filterBuilderUpdater, PaginatorInterface $paginator)
    {

        $qb =  $repository->getIndexQueryBuilder();

        $form = $this->createForm(ActivityFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('activity/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @param Request $request
     * @param ActivityManager $activityManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, ActivityManager $activityManager)
    {
        $activity = $activityManager->new();

        /** @var FormInterface $form */
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activityManager->create($activity);

            $this->addFlash('success', 'L\'activité a été ajoutée avec succès.');

            return $this->redirectToRoute('app_admin_activity_index');
        }

        return $this->render('activity/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Activity $activity
     * @param ActivityManager $activityManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Activity $activity, ActivityManager $activityManager)
    {
        /** @var FormInterface $form */
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $activityManager->update($activity);

            $this->addFlash('success', 'L\'activité a été modifiée avec succès.');

            return $this->redirectToRoute('app_admin_activity_edit', array('id' => $activity->getId()));
        }
        return $this->render('activity/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     * @param Request $request
     * @param ActivityDoctrineRepository $repository
     * @return JsonResponse
     */
    public function autocomplete(Request $request, ActivityDoctrineRepository $repository)
    {
        $query = $request->query->get('query', '');

        $activities = $repository->findLikeQuery($query);
        $activities = array_map(function(Activity $activity){
            return $activity->getLabel();
        }, $activities);

        $activities = array_unique($activities);
        $activities = array_values($activities);

        return $this->json(['query' =>  $query, 'suggestions' => $activities, 'data' => $activities]);
    }

}
