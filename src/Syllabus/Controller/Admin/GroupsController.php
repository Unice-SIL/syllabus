<?php


namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Entity\Groups;
use App\Syllabus\Form\Filter\GroupsFilterType;
use App\Syllabus\Form\GroupsType;
use App\Syllabus\Manager\GroupsManager;
use App\Syllabus\Repository\Doctrine\GroupsDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class GroupsController
 * @package App\Syllabus\Controller
 * @Route("/groups", name="app.admin.groups.")
 * @Security("is_granted('ROLE_ADMIN_GROUPS')")
 */
class GroupsController extends AbstractController
{
    /**
     * Lists all groups entities.
     *
     * @Route("/", name="index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_GROUPS_LIST')")
     * @param Request $request
     * @param GroupsDoctrineRepository $groupsDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function indexAction(
        Request $request,
        GroupsDoctrineRepository $groupsDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater,
        PaginatorInterface $paginator
    )
    {

        $qb = $groupsDoctrineRepository->getIndexQueryBuilder();

        $form = $this->createForm(GroupsFilterType::class);

        if ($request->query->has($form->getName()))
        {
            $form->submit($request->query->get($form->getName()));
            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            5
        );

        $deleteFormsView = [];

        foreach ($pagination as $group) {
            $deleteFormsView[$group->getId()] = $this->createDeleteForm($group)->createView();
        }

        return $this->render('groups/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
            'deleteFormsView' => $deleteFormsView
        ));
    }

    /**
     * Creates a new groups entity.
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_GROUPS_CREATE')")
     * @param Request $request
     * @param GroupsManager $groupsManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, GroupsManager $groupsManager, TranslatorInterface $translator)
    {
        $groups = $groupsManager->new();

        $form = $this->createForm(GroupsType::class, $groups);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupsManager->create($groups);

            $this->addFlash('success', $translator->trans('admin.group.flashbag.new'));

            return $this->redirectToRoute('app.admin.groups.index');
        }

        return $this->render('groups/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing groups entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_GROUPS_UPDATE')")
     * @param Request $request
     * @param Groups $groups
     * @param GroupsManager $groupsManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Groups $groups, GroupsManager $groupsManager, TranslatorInterface $translator)
    {
        $form = $this->createForm(GroupsType::class, $groups);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $groupsManager->update($groups);

            $this->addFlash('success', $translator->trans('admin.group.flashbag.edit'));

            return $this->redirectToRoute('app.admin.groups.edit', array('id' => $groups->getId()));
        }

        return $this->render('groups/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "label"})
     *
     * @param GroupsDoctrineRepository $groupsDoctrineRepository
     * @param Request $request
     * @param $field
     * @return JsonResponse
     */
    public function autocomplete(GroupsDoctrineRepository $groupsDoctrineRepository, Request $request, $field)
    {
        $query = $request->query->get('query');

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $groups = $groupsDoctrineRepository->findLikeQuery($query, $field);

        $groups = array_map(function($group) use ($field, $propertyAccessor){
            return $propertyAccessor->getValue($group, $field);
        }, $groups);

        $groups = array_unique($groups);

        return $this->json(['query' =>  $query, 'suggestions' => $groups, 'data' => $groups]);
    }

    /**
     * Deletes a groups entity.
     *
     * @Route("/delete/{id}", name="delete")
     * @Security("is_granted('ROLE_ADMIN_GROUPS_DELETE')")
     * @param TranslatorInterface $translator
     * @param Groups $groups
     * @param GroupsManager $groupsManager
     * @return RedirectResponse
     */
    public function deleteAction(TranslatorInterface $translator, Groups $groups, GroupsManager $groupsManager)
    {
        $groupsManager->delete($groups);
        $this->addFlash('success', $translator->trans('admin.group.flashbag.delete'));
        return $this->redirectToRoute('app.admin.groups.index');
    }

    /**
     * Creates a form to delete a groups entity.
     * @param Groups $group
     * @return FormInterface
     */
    private function createDeleteForm(Groups $group)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app.admin.groups.delete', array('id' => $group->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}