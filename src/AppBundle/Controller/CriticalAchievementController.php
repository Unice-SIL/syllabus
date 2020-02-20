<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CriticalAchievement;
use AppBundle\Form\CriticalAchievementType;
use AppBundle\Form\Filter\CriticalAchievementFilterType;
use AppBundle\Manager\CriticalAchievementManager;
use AppBundle\Repository\Doctrine\CriticalAchievementDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Activity controller.
 *
 * @Route("/admin/criticalAchievement", name="app_admin_achievement_")
 */
class CriticalAchievementController extends AbstractController
{
    /**
     * @Route("/", name="index" )
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator,
                                FilterBuilderUpdaterInterface $filterBuilderUpdater)
    {
        $qb =  $em->getRepository(CriticalAchievement::class)->createQueryBuilder('ca');

        $form = $this->get('form.factory')->create(CriticalAchievementFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('critical_achievement/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/view", name="new"))
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function newAction(Request $request, CriticalAchievementManager $criticalAchievementManager)
    {
        $criticalAchievement = $criticalAchievementManager->create();
        $form = $this->createForm(CriticalAchievementType::class, $criticalAchievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($criticalAchievement);
            $em->flush();

            $this->addFlash('success', 'L\'acquis critique a été ajouté avec succès.');

            return $this->redirectToRoute('app_admin_achievement_index');
        }

        return $this->render('critical_achievement/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("{id}/edit", name="edit"))
     *
     * @param Request $request
     * @param CriticalAchievement $criticalAchievement
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, CriticalAchievement $criticalAchievement)
    {
        $form = $this->createForm(CriticalAchievementType::class, $criticalAchievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'L\'acquis critique a été modifié avec succès.');

            return $this->redirectToRoute('app_admin_achievement_edit', array('id' => $criticalAchievement->getId()));
        }

        return $this->render('critical_achievement/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     *
     * @param CriticalAchievementDoctrineRepository $criticalAchievementDoctrineRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocomplete(CriticalAchievementDoctrineRepository $criticalAchievementDoctrineRepository, Request $request)
    {
        $query = $request->query->get('query');

        $criticalAchievements = $criticalAchievementDoctrineRepository->findLikeQuery($query);
        $criticalAchievements = array_map(function($mode){
            return $mode->getLabel();
        }, $criticalAchievements);

        $criticalAchievements = array_unique($criticalAchievements);
        $criticalAchievements = array_values($criticalAchievements);

        return $this->json(['query' =>  $query, 'suggestions' => $criticalAchievements, 'data' => $criticalAchievements]);
    }
}