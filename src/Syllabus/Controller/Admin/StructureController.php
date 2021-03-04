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
 * @Route("/structure", name="app.admin.structure.")
 * @Security("is_granted('ROLE_ADMIN_STRUCTURE')")
 */
class StructureController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Security("is_granted('ROLE_ADMIN_STRUCTURE_LIST')")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param StructureDoctrineRepository $structureDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        PaginatorInterface $paginator,
        StructureDoctrineRepository $structureDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {

        $qb = $structureDoctrineRepository->getIndexQueryBuilder();

        $form = $this->createForm(StructureFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));
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
     * @Route("/new", name="new")
     * @Security("is_granted('ROLE_ADMIN_STRUCTURE_CREATE')")
     *
     * @param Request $request
     * @param StructureManager $structureManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, StructureManager $structureManager, TranslatorInterface $translator)
    {
        $structure = $structureManager->new();
        $form = $this->createForm(StructureType::class, $structure, ['context' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $structureManager->create($structure);

            $this->addFlash('success', $translator->trans('admin.structure.flashbag.new'));

            return $this->redirectToRoute('app.admin.structure.index');
        }
        return $this->render('structure/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Displays a form to edit an existing structure entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_STRUCTURE_UPDATE')")
     *
     * @param Request $request
     * @param Structure $structure
     * @param StructureManager $structureManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Structure $structure, StructureManager $structureManager, TranslatorInterface $translator)
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
        ));
    }

    /**
     * @Route("/autocompleteS2", name="autocompleteS2", methods={"GET"})
     * @param StructureDoctrineRepository $structureDoctrineRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteS2(StructureDoctrineRepository $structureDoctrineRepository, Request $request)
    {
        $query = $request->query->get('q');

        $structures = $structureDoctrineRepository->findLikeQuery($query, 'label');

        $data = array_map(function ($s) use ($request) {
            return ['id' => $s->getId(), 'text' => $s->getLabel()];
        }, $structures);

        return $this->json($data);
    }
}
