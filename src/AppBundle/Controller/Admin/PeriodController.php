<?php


namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Period;
use AppBundle\Entity\Structure;
use AppBundle\Form\Filter\PeriodFilterType;
use AppBundle\Form\PeriodType;
use AppBundle\Manager\PeriodManager;
use AppBundle\Repository\Doctrine\PeriodDoctrineRepository;
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
 * @package AppBundle\Controller
 *
 * @Route("/period", name="app.admin.period.")
 * @Security("has_role('ROLE_ADMIN_PERIOD')")
 */
class PeriodController extends AbstractController
{
    /**
     * @Route("/",name="index", methods={"GET"})
     * @Security("has_role('ROLE_ADMIN_PERIOD_LIST')")
     *
     * @param Request $request
     * @param PeriodDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        PeriodDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {
        $qb =  $repository->getIndexQueryBuilder();

        $form = $this->createForm(PeriodFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('period/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_PERIOD_CREATE')")
     *
     * @param Request $request
     * @param PeriodManager $periodManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, PeriodManager $periodManager)
    {
        $period = $periodManager->new();
        $form = $this->createForm(PeriodType::class, $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $periodManager->create($period);

            $this->addFlash('success', 'La période a été ajoutée avec succès.');

            return $this->redirectToRoute('app.admin.period.index');
        }

        return $this->render('period/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_PERIOD_UPDATE')")
     *
     * @param Request $request
     * @param Period $period
     * @param PeriodManager $periodManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Period $period, PeriodManager $periodManager)
    {
        $form = $this->createForm(PeriodType::class, $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $periodManager->update($period);

            $this->addFlash('success', 'La période été modifiée avec succès.');

            return $this->redirectToRoute('app.admin.period.edit', array('id' => $period->getId()));
        }

        return $this->render('period/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     * @param PeriodDoctrineRepository $periodDoctrineRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocomplete(PeriodDoctrineRepository $periodDoctrineRepository, Request $request)
    {
        $query = $request->query->get('query');

        $periods = $periodDoctrineRepository->findLikeQuery($query);
        $periods = array_map(function($period){
            return $period->getLabel();
        }, $periods);

        $periods = array_unique($periods);
        $periods = array_values($periods);

        return $this->json(['query' =>  $query, 'suggestions' => $periods, 'data' => $periods]);
    }

    /**
     * @Route("/autocompleteS2/{structure}", name="autocompleteS2")
     *
     * @param Structure $structure
     * @return Response
     */
    public function autocompleteS2(Structure $structure)
    {
        $data = [];
        $periods = $structure->getPeriods();
        if(!empty($periods)){
            foreach ($periods as $period){
                $data[] = ['id' => $period->getId(), 'text' => $period->getLabel()];
            }
        }
        return $this->json($data);
    }
}