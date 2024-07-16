<?php

namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Equipment;
use App\Syllabus\Form\EquipmentType;
use App\Syllabus\Form\Filter\EquipmentFilterType;
use App\Syllabus\Manager\EquipmentManager;
use App\Syllabus\Repository\Doctrine\EquipmentDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class EquipmentController
 * @package App\Syllabus\Controller
 *
 * @Route("/equipment", name="app.admin.equipment.")
 * @Security("is_granted('ROLE_ADMIN_EQUIPMENT')")
 */
class EquipmentController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Security("is_granted('ROLE_ADMIN_EQUIPMENT_LIST')")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param EquipmentDoctrineRepository $equipmentDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        PaginatorInterface $paginator,
        EquipmentDoctrineRepository $equipmentDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    ): Response
    {

        $qb = $equipmentDoctrineRepository->getIndexQueryBuilder();

        $form = $this->createForm(EquipmentFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));
            $filterBuilderUpdater->addFilterConditions($form, $qb);

        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('equipment/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new equipment.
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_EQUIPMENT_CREATE')")
     *
     * @param Request $request
     * @param EquipmentManager $equipmentManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, EquipmentManager $equipmentManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $equipment = $equipmentManager->new();
        $form = $this->createForm(EquipmentType::class, $equipment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipmentManager->create($equipment);

            $this->addFlash('success', $translator->trans('admin.equipment.flashbag.new'));

            return $this->redirectToRoute('app.admin.equipment.index');
        }

        return $this->render('equipment/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipment entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_EQUIPMENT_UPDATE')")
     *
     * @param Request $request
     * @param Equipment $equipment
     * @param EquipmentManager $equipmentManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Equipment $equipment, EquipmentManager $equipmentManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $equipmentManager->update($equipment);

            $this->addFlash('success', $translator->trans('admin.equipment.flashbag.edit'));

            return $this->redirectToRoute('app.admin.equipment.edit', array('id' => $equipment->getId()));
        }

        return $this->render('equipment/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
