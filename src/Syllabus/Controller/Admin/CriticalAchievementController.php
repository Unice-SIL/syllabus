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
 * @Security("is_granted('ROLE_ADMIN_CRITICAL_ACHIEVEMENT')")
 */
#[Route(path: '/critical-achievement', name: 'app.admin.critical_achievement.')]
class CriticalAchievementController extends AbstractController
{
    /**
     * @Security("is_granted('ROLE_ADMIN_CRITICAL_ACHIEVEMENT_LIST')")
     *
     */
    #[Route(path: '/', name: 'index')]
    public function indexAction(
        Request $request,
        CriticalAchievementDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    ): Response
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

    
    #[Route(path: '/new', name: 'new')] // @Security("is_granted('ROLE_ADMIN_CRITICAL_ACHIEVEMENT_CREATE')")
    public function newAction(Request $request, CriticalAchievementManager $criticalAchievementManager, TranslatorInterface $translator): Response
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

    
    #[Route(path: '{id}/edit', name: 'edit')] // @Security("is_granted('ROLE_ADMIN_CRITICAL_ACHIEVEMENT_UPDATE')")
    public function editAction(Request $request, CriticalAchievement $criticalAchievement, CriticalAchievementManager $criticalAchievementManager, TranslatorInterface $translator): RedirectResponse|Response
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

    
    #[Route(path: '/autocompleteByCourse/{courseInfo}', name: 'autocompleteByCourse', methods: ['GET'])]
    public function autocompleteByCourse(CourseInfo $courseInfo, CriticalAchievementDoctrineRepository $criticalAchievementDoctrineRepository,
                                          Request $request): JsonResponse
    {
        $query = $request->query->all('q');

        $criticalAchievements = $criticalAchievementDoctrineRepository->findLikeQueryByCourse($query, $courseInfo->getCourse());
        $result = [];
        foreach ($criticalAchievements as $ca){
            $result[] = ['id' => $ca->getId(), 'text' => $ca->getLabel()];
        }

        return $this->json($result);

    }
}