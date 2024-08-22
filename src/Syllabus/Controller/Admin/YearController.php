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
 * @Security("is_granted('ROLE_ADMIN_YEAR')")
 */
#[Route(path: '/year', name: 'app.admin.year.')]
class YearController extends AbstractController
{
    /**
     * Lists all year entities.
     *
     * @Security("is_granted('ROLE_ADMIN_YEAR_LIST')")
     *
     */
    #[Route(path: '/', name: 'index', methods: ['GET'])]
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
     * @Security("is_granted('ROLE_ADMIN_YEAR_CREATE')")
     */
    #[Route(path: '/new', name: 'new', methods: ['GET', 'POST'])]
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
     * @Security("is_granted('ROLE_ADMIN_YEAR_UPDATE')")
     */
    #[Route(path: '/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
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

    #[Route(path: '/autocompleteS2', name: 'autocompleteS2', methods: ['GET'])]
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
