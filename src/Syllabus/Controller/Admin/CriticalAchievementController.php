<?php


namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CriticalAchievement;
use App\Syllabus\Form\CriticalAchievementType;
use App\Syllabus\Form\Filter\CriticalAchievementFilterType;
use App\Syllabus\Manager\CriticalAchievementManager;
use App\Syllabus\Repository\Doctrine\CriticalAchievementDoctrineRepository;
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
 * Activity controller.
 *
 * @Route("/critical-achievement", name="app.admin.critical_achievement.")
 * @Security("is_granted('ROLE_ADMIN_CRITICAL_ACHIEVEMENT')")
 */
class CriticalAchievementController extends AbstractController
{
    /**
     * @Route("/", name="index" )
     * @Security("is_granted('ROLE_ADMIN_CRITICAL_ACHIEVEMENT_LIST')")
     *
     * @param Request $request
     * @param CriticalAchievementDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        CriticalAchievementDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {
        $qb =  $repository->getIndexQueryBuilder();

        $form = $this->createForm(CriticalAchievementFilterType::class);

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
     * @Route("/new", name="new"))
     * @Security("is_granted('ROLE_ADMIN_CRITICAL_ACHIEVEMENT_CREATE')")
     *
     * @param Request $request
     * @param CriticalAchievementManager $criticalAchievementManager
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function newAction(Request $request, CriticalAchievementManager $criticalAchievementManager, TranslatorInterface $translator)
    {
        $criticalAchievement = $criticalAchievementManager->new();
        $form = $this->createForm(CriticalAchievementType::class, $criticalAchievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $criticalAchievementManager->create($criticalAchievement);
            $this->addFlash('success', $translator->trans('admin.critical_achievement.flashbag.new'));

            return $this->redirectToRoute('app.admin.critical_achievement.index');
        }
        return $this->render('critical_achievement/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("{id}/edit", name="edit"))
     * @Security("is_granted('ROLE_ADMIN_CRITICAL_ACHIEVEMENT_UPDATE')")
     *
     * @param Request $request
     * @param CriticalAchievement $criticalAchievement
     * @param CriticalAchievementManager $criticalAchievementManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, CriticalAchievement $criticalAchievement, CriticalAchievementManager $criticalAchievementManager, TranslatorInterface $translator)
    {
        $form = $this->createForm(CriticalAchievementType::class, $criticalAchievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $criticalAchievementManager->update($criticalAchievement);

            $this->addFlash('success', $translator->trans('admin.critical_achievement.flashbag.edit'));
            return $this->redirectToRoute('app.admin.critical_achievement.edit', array('id' => $criticalAchievement->getId()));
        }

        return $this->render('critical_achievement/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocompleteByCourse/{courseInfo}", name="autocompleteByCourse", methods={"GET"})
     *
     * @param CriticalAchievementDoctrineRepository $criticalAchievementDoctrineRepository
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteByCourse(CourseInfo $courseInfo, CriticalAchievementDoctrineRepository $criticalAchievementDoctrineRepository,
                                          Request $request)
    {
        $query = $request->query->all('q', '');

        $criticalAchievements = $criticalAchievementDoctrineRepository->findLikeQueryByCourse($query, $courseInfo->getCourse());
        $result = [];
        foreach ($criticalAchievements as $ca){
            $result[] = ['id' => $ca->getId(), 'text' => $ca->getLabel()];
        }

        return $this->json($result);

    }
}