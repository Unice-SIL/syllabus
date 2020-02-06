<?php


namespace AppBundle\Controller;


use AppBundle\Entity\ActivityType;
use AppBundle\Form\ActivityTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActivityTypeController
 * @package AppBundle\Controller
 *
 * @Route("/admin/type_activity", name="app_admin_type_activity_")
 */
class ActivityTypeController extends AbstractController
{

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route("/",name="index" )
     * @Method("GET")
     * @return Response
     */
    public function IndexAction(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $qb =  $em->getRepository(ActivityType::class)->createQueryBuilder('a');

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('activity_type/index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * Creates a new activity.
     *
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param ActivityTypeManager $activityTypeManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, ActivityTypeManager $activityTypeManager)
    {
        $activityType = $activityTypeManager->create();
        dump($activityType);
        $form = $this->createForm(ActivityTypeType::class, $activityType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($activityType);
            $em->flush();

            $this->addFlash('success', 'Le type d\'activité a été ajoutée avec succès.');

            return $this->redirectToRoute('app_admin_type_activity_index');
        }

        return $this->render('activity_type/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param ActivityType $activityType
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, ActivityType $activityType)
    {
        $form = $this->createForm(ActivityTypeType::class, $activityType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'L\'activité a été modifiée avec succès.');

            return $this->redirectToRoute('app_admin_type_activity_edit', array('id' => $activityType->getId()));
        }

        return $this->render('activity_type/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     * @param ActivityTypeDoctrineRepository $activityTypeDoctrineRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function autocomplete(ActivityTypeDoctrineRepository $activityTypeDoctrineRepository, Request $request)
    {
        $query = $request->query->get('query');

        $activitieTypes = $activityTypeDoctrineRepository->findLikeQuery($query, $request->query->get('field'));
        $activitieTypes = array_map(function($activityType){
            return $activityType->getLabel();
        }, $activitieTypes);

        $activitieTypes = array_unique($activitieTypes);
        $activitieTypes = array_values($activitieTypes);

        return $this->json(['query' =>  $query, 'suggestions' => $activitieTypes, 'data' => $activitieTypes]);
    }

}