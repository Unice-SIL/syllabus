<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Structure;
use AppBundle\Form\Filter\StructureFilterType;
use AppBundle\Form\StructureType;
use AppBundle\Manager\StructureManager;
use AppBundle\Repository\Doctrine\StructureDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StructureController
 * @package AppBundle\Controller
 *
 * @Route("/admin/structure", name="app.admin.structure.")
 * @Security("has_role('ROLE_ADMIN_STRUCTURE')")
 */
class StructureController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Security("has_role('ROLE_ADMIN_STRUCTURE_LIST')")
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
     * @Security("has_role('ROLE_ADMIN_STRUCTURE_CREATE')")
     *
     * @param Request $request
     * @param StructureManager $structureManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, StructureManager $structureManager)
    {
        $structure = $structureManager->new();
        $form = $this->createForm(StructureType::class, $structure, ['context' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $structureManager->create($structure);

            $this->addFlash('success', 'La structure a été enregistrée avec succès');

            return $this->redirectToRoute('app.admin.structure.index');
        }
        return $this->render('structure/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Displays a form to edit an existing structure entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_STRUCTURE_UPDATE')")
     *
     * @param Request $request
     * @param Structure $structure
     * @param StructureManager $structureManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Structure $structure, StructureManager $structureManager)
    {
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureManager->update($structure);

            $this->addFlash('success', 'La strucutre a été modifiée avec succès.');
            return $this->redirectToRoute('app.admin.structure.edit', array('id' => $structure->getId()));
        }

        return $this->render('structure/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "code|label|campus"})
     *
     * @param StructureDoctrineRepository $structureDoctrineRepository
     * @param Request $request
     * @param $field
     * @return JsonResponse
     */
    public function autocomplete(StructureDoctrineRepository $structureDoctrineRepository, Request $request, $field)
    {
        $query = $request->query->get('query');

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $structures = $structureDoctrineRepository->findLikeQuery($query, $field);

        $structures = array_map(function($structure) use ($field, $propertyAccessor){
            return $propertyAccessor->getValue($structure, $field);
        }, $structures);

        $structures = array_unique($structures);

        return $this->json(['query' =>  $query, 'suggestions' => $structures, 'data' => $structures]);
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
