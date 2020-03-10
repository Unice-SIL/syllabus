<?php


namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Campus;
use AppBundle\Form\CampusType;
use AppBundle\Form\Filter\CampusFilterType;
use AppBundle\Manager\CampusManager;
use AppBundle\Repository\Doctrine\CampusDoctrineRepository;
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
 * Class CampusController
 * @package AppBundle\Controller\Admin
 *
 * @Route("/admin/campus", name="app.admin.campus.")
 * @Security("has_role('ROLE_ADMIN_CAMPUS')")
 */
class CampusController extends AbstractController
{
    /**
     * @Route("/",name="index", methods={"GET"})
     * @Security("has_role('ROLE_ADMIN_CAMPUS_LIST')")
     *
     * @param Request $request
     * @param CampusDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function IndexAction(
        Request $request,
        CampusDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
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

        return $this->render('Campus/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_CAMPUS_CREATE')")
     *
     * @param Request $request
     * @param CampusManager $campusManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, CampusManager $campusManager)
    {
        $campus = $campusManager->new();
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campusManager->create($campus);

            $this->addFlash('success', 'La langue a été ajoutée avec succès.');

            return $this->redirectToRoute('app.admin.campus.index');
        }

        return $this->render('Campus/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_CAMPUS_UPDATE')")
     *
     * @param Request $request
     * @param Campus $campus
     * @param CampusManager $campusManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Campus $campus, CampusManager $campusManager)
    {
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $campusManager->update($campus);

            $this->addFlash('success', 'La Campus été modifié avec succès.');

            return $this->redirectToRoute('app.admin.campus.edit', array('id' => $campus->getId()));
        }

        return $this->render('campus/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("autocompleteS2", name="autocompleteS2", methods={"GET"})
     *
     * @param CampusDoctrineRepository $repository
     * @param Request $request
     * @return Response
     */
    public function autocompleteS2(CampusDoctrineRepository $repository, Request $request)
    {
        $query = $request->query->get('c');

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