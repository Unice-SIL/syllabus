<?php

namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Entity\ActivityMode;
use App\Syllabus\Form\ActivityModeType;
use App\Syllabus\Form\Filter\ActivityModeFilterType;
use App\Syllabus\Manager\ActivityModeManager;
use App\Syllabus\Repository\Doctrine\ActivityModeDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ActivityModeController
 * @package App\Syllabus\Controller
 *
 * @Route("/activity-mode", name="app.admin.activity_mode.")
 * @Security("is_granted('ROLE_ADMIN_ACTIVITYMODE')")
 */
class ActivityModeController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_ACTIVITYMODE_LIST')")
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
    ): Response
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
     * @Security("is_granted('ROLE_ADMIN_ACTIVITYMODE_CREATE')")
     *
     * @param Request $request
     * @param ActivityModeManager $activityTypeManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, ActivityModeManager $activityTypeManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $activityMode = $activityTypeManager->new();
        $form = $this->createForm(ActivityModeType::class, $activityMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $activityTypeManager->create($activityMode);

            $this->addFlash('success', $translator->trans('admin.activity_mode.flashbag.new'));

            return $this->redirectToRoute('app.admin.activity_mode.index');
        }

        return $this->render('activity_mode/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_ACTIVITYMODE_UPDATE')")
     *
     * @param Request $request
     * @param ActivityMode $activityMode
     * @param ActivityModeManager $activityModeManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, ActivityMode $activityMode, ActivityModeManager $activityModeManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $form = $this->createForm(ActivityModeType::class, $activityMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $activityModeManager->update($activityMode);

            $this->addFlash('success', $translator->trans('admin.activity_mode.flashbag.edit'));

            return $this->redirectToRoute('app.admin.activity_mode.edit', array('id' => $activityMode->getId()));
        }

        return $this->render('activity_mode/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}