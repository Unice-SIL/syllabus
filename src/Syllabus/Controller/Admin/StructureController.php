<?php

namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Structure;
use App\Syllabus\Form\Filter\StructureFilterType;
use App\Syllabus\Form\StructureType;
use App\Syllabus\Manager\StructureManager;
use App\Syllabus\Repository\Doctrine\StructureDoctrineRepository;
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
 * Class StructureController
 * @package App\Syllabus\Controller
 *
 * @Security("is_granted('ROLE_ADMIN_STRUCTURE')")
 */
#[Route(path: '/structure', name: 'app.admin.structure.')]
class StructureController extends AbstractController
{
    /**
     * @Security("is_granted('ROLE_ADMIN_STRUCTURE_LIST')")
     *
     */
    #[Route(path: '/', name: 'index')]
    public function indexAction(
        Request $request,
        PaginatorInterface $paginator,
        StructureDoctrineRepository $structureDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    ): Response
    {

        $parameters = $request->query->all();
        $qb = $structureDoctrineRepository->getIndexQueryBuilder();

        $form = $this->createForm(StructureFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($parameters[$form->getName()]);
            $filterBuilderUpdater->addFilterConditions($form, $qb);

        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('structure/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Security("is_granted('ROLE_ADMIN_STRUCTURE_CREATE')")
     *
     */
    #[Route(path: '/new', name: 'new')]
    public function newAction(Request $request, StructureManager $structureManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $structure = $structureManager->new();
        $form = $this->createForm(StructureType::class, $structure, ['context' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureManager->create($structure);

            $this->addFlash('success', $translator->trans('admin.structure.flashbag.new'));

            return $this->redirectToRoute('app.admin.structure.index');
        }
        return $this->render('structure/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Displays a form to edit an existing structure entity.
     *
     * @Security("is_granted('ROLE_ADMIN_STRUCTURE_UPDATE')")
     *
     */
    #[Route(path: '/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, Structure $structure, StructureManager $structureManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureManager->update($structure);

            $this->addFlash('success', $translator->trans('admin.structure.flashbag.edit'));
            return $this->redirectToRoute('app.admin.structure.edit', array('id' => $structure->getId()));
        }

        return $this->render('structure/edit.html.twig', array(
            'form' => $form->createView(),
            'structure' => $structure
        ));
    }

    #[Route(path: '/autocompleteS2', name: 'autocompleteS2', methods: ['GET'])]
    public function autocompleteS2(StructureDoctrineRepository $structureDoctrineRepository, Request $request): JsonResponse
    {
        $parameters = $request->query->all();
        $query = $parameters['q'];

        $structures = $structureDoctrineRepository->findLikeQuery($query, 'label');

        $data = array_map(function ($s) use ($request) {
            return ['id' => $s->getId(), 'text' => $s->getLabel()];
        }, $structures);

        return $this->json($data);
    }
}
