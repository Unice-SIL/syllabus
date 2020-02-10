<?php


namespace AppBundle\Controller;


use AppBundle\Entity\ActivityMode;
use AppBundle\Form\ActivityModeType;
use AppBundle\Form\Filter\ActivityModeFilterType;
use AppBundle\Manager\ActivityModeManager;
use AppBundle\Repository\Doctrine\ActivityModeDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
 * @Route("/admin/mode_activity", name="app_admin_mode_activity_")
 */
class ActivityModeController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     * @Route("/",name="index" )
     * @Method("GET")
     */
    public function IndexAction(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator, FilterBuilderUpdaterInterface $filterBuilderUpdater)
    {
        $qb =  $em->getRepository(ActivityMode::class)->createQueryBuilder('am');

        $form = $this->get('form.factory')->create(ActivityModeFilterType::class);

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
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param ActivityModeManager $activityTypeManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, ActivityModeManager $activityTypeManager)
    {
        $activityMode = $activityTypeManager->create();
        $form = $this->createForm(ActivityModeType::class, $activityMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($activityMode);
            $em->flush();

            $this->addFlash('success', 'Le mode d\'activité a été ajoutée avec succès.');

            return $this->redirectToRoute('app_admin_mode_activity_index');
        }

        return $this->render('activity_mode/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param ActivityMode $activityMode
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, ActivityMode $activityMode)
    {
        $form = $this->createForm(ActivityModeType::class, $activityMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Le mode d\'activité a été modifiée avec succès.');

            return $this->redirectToRoute('app_admin_mode_activity_edit', array('id' => $activityMode->getId()));
        }

        return $this->render('activity_mode/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     * @param ActivityModeDoctrineRepository $activityModeDoctrineRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocomplete(ActivityModeDoctrineRepository $activityModeDoctrineRepository, Request $request)
    {
        $query = $request->query->get('query');

        $activitiesModes = $activityModeDoctrineRepository->findLikeQuery($query);
        $activitiesModes = array_map(function($mode){
            return $mode->getLabel();
        }, $activitiesModes);

        $activitiesModes = array_unique($activitiesModes);
        $activitiesModes = array_values($activitiesModes);

        return $this->json(['query' =>  $query, 'suggestions' => $activitiesModes, 'data' => $activitiesModes]);
    }
}