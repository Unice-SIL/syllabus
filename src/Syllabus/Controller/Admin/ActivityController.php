<?php

namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Activity;
use App\Syllabus\Form\ActivityType;
use App\Syllabus\Form\Filter\ActivityFilterType;
use App\Syllabus\Manager\ActivityManager;
use App\Syllabus\Repository\Doctrine\ActivityDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Activity controller.
 *
 * @Security("is_granted('ROLE_ADMIN_ACTIVITY')")
 * @Route("/activity", name="app.admin.activity.")
 */
class ActivityController extends AbstractController
{
    /**
     * Lists all activity entities.
     *
     * @Route("/", name="index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_ACTIVITY_LIST')")
     * @param Request $request
     * @param ActivityDoctrineRepository $repository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function indexAction(
        Request $request,
        ActivityDoctrineRepository $repository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater,
        PaginatorInterface $paginator
    )
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
     * @Security("is_granted('ROLE_ADMIN_ACTIVITY_CREATE')")
     * @param Request $request
     * @param ActivityManager $activityManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, ActivityManager $activityManager, TranslatorInterface $translator)
    {
        $activity = $activityManager->new();

        /** @var FormInterface $form */
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activityManager->create($activity);

            $this->addFlash('success', $translator->trans('admin.activity.flashbag.new'));

            return $this->redirectToRoute('app.admin.activity.index');
        }

        return $this->render('activity/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_ACTIVITY_UPDATE')")
     * @param Request $request
     * @param Activity $activity
     * @param ActivityManager $activityManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Activity $activity, ActivityManager $activityManager, TranslatorInterface $translator)
    {
        /** @var FormInterface $form */
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $activityManager->update($activity);

            $this->addFlash('success', $translator->trans('admin.activity.flashbag.edit'));

            return $this->redirectToRoute('app.admin.activity.edit', array('id' => $activity->getId()));
        }
        return $this->render('activity/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
