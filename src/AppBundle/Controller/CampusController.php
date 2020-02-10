<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Campus;
use AppBundle\Form\CampusType;
use AppBundle\Form\Filter\CampusFilterType;
use AppBundle\Manager\CampusManager;
use AppBundle\Repository\Doctrine\CampusDoctrineRepository;
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
 * Class CampusController
 * @package AppBundle\Controller
 *
 * @Route("/admin/campus", name="app_admin_campus_")
 */
class CampusController extends AbstractController
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
        $qb =  $em->getRepository(Campus::class)->createQueryBuilder('l');

        $form = $this->get('form.factory')->create(CampusFilterType::class);

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
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param CampusManager $campusManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, CampusManager $campusManager)
    {
        $campus = $campusManager->create();
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($campus);
            $em->flush();

            $this->addFlash('success', 'La langue a été ajoutée avec succès.');

            return $this->redirectToRoute('app_admin_campus_index');
        }

        return $this->render('Campus/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Campus $campus
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Campus $campus)
    {
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La Campus été modifié avec succès.');

            return $this->redirectToRoute('app_admin_campus_edit', array('id' => $campus->getId()));
        }

        return $this->render('campus/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     * @param CampusDoctrineRepository $campusDoctrineRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocomplete(CampusDoctrineRepository $campusDoctrineRepository, Request $request)
    {
        $query = $request->query->get('query');

        $campuss = $campusDoctrineRepository->findLikeQuery($query);
        $campuss = array_map(function($campus){
            return $campus->getLabel();
        }, $campuss);

        $campuss = array_unique($campuss);
        $campuss = array_values($campuss);

        return $this->json(['query' =>  $query, 'suggestions' => $campuss, 'data' => $campuss]);
    }
}