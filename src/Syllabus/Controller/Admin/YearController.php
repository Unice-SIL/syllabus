<?php

namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Year;
use App\Syllabus\Form\YearType;
use App\Syllabus\Manager\YearManager;
use App\Syllabus\Repository\Doctrine\YearDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class YearController
 * @package App\Syllabus\Controller\Admin
 *
 * @Route("/year", name="app.admin.year.")
 * @Security("is_granted('ROLE_ADMIN_YEAR')")
 */
class YearController extends AbstractController
{
    /**
     * Lists all year entities.
     *
     * @Route("/", name="index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_YEAR_LIST')")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function indexAction(Request $request, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {
        $pagination = $paginator->paginate(
            $em->createQuery("SELECT y FROM Syllabus:Year y"),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('year/index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new year entity.
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_YEAR_CREATE')")
     * @param Request $request
     * @param YearManager $yearManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, YearManager $yearManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $year = $yearManager->new();

        $form = $this->createForm(YearType::class, $year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yearManager->create($year);
            $this->addFlash('success', $translator->trans('admin.year.flashbag.new'));

            return $this->redirectToRoute('app.admin.year.index');
        }

        return $this->render('year/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing year entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_YEAR_UPDATE')")
     * @param Request $request
     * @param Year $year
     * @param YearManager $yearManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Year $year, YearManager $yearManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $form = $this->createForm('App\Syllabus\Form\YearType', $year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $yearManager->update($year);

            $this->addFlash('success', $translator->trans('admin.year.flashbag.edit'));

            return $this->redirectToRoute('app.admin.year.edit', array('id' => $year->getId()));
        }

        return $this->render('year/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocompleteS2", name="autocompleteS2", methods={"GET"})
     * @param YearDoctrineRepository $yearDoctrineRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteS2(YearDoctrineRepository $yearDoctrineRepository, Request $request): JsonResponse
    {
        $parameters = $request->query->all();
        $query = $parameters['q'];

        $years = $yearDoctrineRepository->findLikeQuery($query, 'y.label');

        $data = array_map(function ($y) use ($request) {
            return ['id' => $y->getId(), 'text' => $y->getLabel()];
        }, $years);

        return $this->json($data);
    }
}
