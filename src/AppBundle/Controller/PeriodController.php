<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Period;
use AppBundle\Form\Filter\PeriodFilterType;
use AppBundle\Form\PeriodType;
use AppBundle\Manager\PeriodManager;
use AppBundle\Repository\Doctrine\PeriodDoctrineRepository;
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
 * @package AppBundle\Controller
 *
 * @Route("/admin/period", name="app_admin_period_")
 */

class PeriodController extends AbstractController
{
    /**
     * @Route("/",name="index" )
     * @Method("GET")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     *
     */
    public function IndexAction(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator, FilterBuilderUpdaterInterface $filterBuilderUpdater)
    {
        $qb =  $em->getRepository(Period::class)->createQueryBuilder('d');

        $form = $this->get('form.factory')->create(PeriodFilterType::class);

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
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param PeriodManager $periodManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, PeriodManager $periodManager)
    {
        $period = $periodManager->create();
        $form = $this->createForm(PeriodType::class, $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($period);
            $em->flush();

            $this->addFlash('success', 'La période a été ajoutée avec succès.');

            return $this->redirectToRoute('app_admin_period_index');
        }

        return $this->render('period/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Period $period
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Period $period)
    {
        $form = $this->createForm(PeriodType::class, $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dump($data);
            $this->getDoctrine()->getManager()->flush();
            dump('apres');
            $this->addFlash('success', 'La période été modifiée avec succès.');

            return $this->redirectToRoute('app_admin_period_edit', array('id' => $period->getId()));
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
}