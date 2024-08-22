<?php


namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Entity\Campus;
use App\Syllabus\Form\CampusType;
use App\Syllabus\Form\Filter\CampusFilterType;
use App\Syllabus\Manager\CampusManager;
use App\Syllabus\Repository\Doctrine\CampusDoctrineRepository;
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
 * Class CampusController
 * @package App\Syllabus\Controller\Admin
 *
 * @Security("is_granted('ROLE_ADMIN_CAMPUS')")
 */
#[Route(path: '/campus', name: 'app.admin.campus.')]
class CampusController extends AbstractController
{
    /**
     * @Security("is_granted('ROLE_ADMIN_CAMPUS_LIST')")
     *
     */
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function IndexAction(
        Request $request,
        CampusDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    ): Response
    {
        $qb =  $repository->getIndexQueryBuilder();

        $form = $this->createForm(CampusFilterType::class);

        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('campus/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Security("is_granted('ROLE_ADMIN_CAMPUS_CREATE')")
     *
     */
    #[Route(path: '/new', name: 'new', methods: ['GET', 'POST'])]
    public function newAction(Request $request, CampusManager $campusManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $campus = $campusManager->new();
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campusManager->create($campus);

            $this->addFlash('success', $translator->trans('admin.campus.flashbag.new'));

            return $this->redirectToRoute('app.admin.campus.index');
        }

        return $this->render('campus/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @Security("is_granted('ROLE_ADMIN_CAMPUS_UPDATE')")
     *
     */
    #[Route(path: '/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, Campus $campus, CampusManager $campusManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $campusManager->update($campus);

            $this->addFlash('success', $translator->trans('admin.campus.flashbag.edit'));

            return $this->redirectToRoute('app.admin.campus.edit', array('id' => $campus->getId()));
        }

        return $this->render('campus/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    
    #[Route(path: 'autocompleteS2', name: 'autocompleteS2', methods: ['GET'])]
    public function autocompleteS2(CampusDoctrineRepository $repository, Request $request): Response
    {
        $parameters =  $request->query->all();
        $query = $parameters['c'];

        $em = $repository->getIndexQueryBuilder();
        $campuses = $em->andWhere('c.label LIKE :query ')
            ->andWhere('c.obsolete = 0')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult()
        ;

        $data = [];
        foreach ($campuses as $campus)
        {
            $data[] = ['id' => $campus->getId(), 'text' => $campus->getLabel()];
        }
        return $this->json($data);
    }
}