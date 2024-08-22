<?php


namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Entity\Level;
use App\Syllabus\Form\Filter\LevelFilterType;
use App\Syllabus\Form\LevelType;
use App\Syllabus\Manager\LevelManager;
use App\Syllabus\Repository\Doctrine\LevelDoctrineRepository;
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
 * Class LevelController
 * @package App\Syllabus\Controller
 *
 * @Security("is_granted('ROLE_ADMIN_LEVEL')")
 */
#[Route(path: '/level', name: 'app.admin.level.')]
class LevelController extends AbstractController
{
    /**
     * @Security("is_granted('ROLE_ADMIN_LEVEL_LIST')")
     *
     */
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function IndexAction(
        Request $request,
        LevelDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    ): Response
    {
        $qb =  $repository->getIndexQueryBuilder();

        $form = $this->createForm(LevelFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('level/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Security("is_granted('ROLE_ADMIN_LEVEL_CREATE')")
     */
    #[Route(path: '/new', name: 'new', methods: ['GET', 'POST'])]
    public function newAction(Request $request, LevelManager $levelManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $level = $levelManager->new();
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $levelManager->create($level);
            $this->addFlash('success', $translator->trans('admin.level.flashbag.new'));

            return $this->redirectToRoute('app.admin.level.index');
        }

        return $this->render('level/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Security("is_granted('ROLE_ADMIN_LEVEL_UPDATE')")
     */
    #[Route(path: '/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, Level $level, LevelManager $levelManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $levelManager->update($level);

            $this->addFlash('success', $translator->trans('admin.level.flashbag.edit'));

            return $this->redirectToRoute('app.admin.level.edit', array('id' => $level->getId()));
        }

        return $this->render('level/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    #[Route(path: '/autocomplete', name: 'autocomplete', methods: ['GET'])]
    public function autocomplete(LevelDoctrineRepository $levelDoctrineRepository, Request $request): JsonResponse
    {
        $parameters = $request->query->all();
        $query = $parameters['query'];

        $levels = $levelDoctrineRepository->findLikeQuery($query);
        $levels = array_map(function($level){
            return $level->getLabel();
        }, $levels);

        $levels = array_unique($levels);
        $levels = array_values($levels);

        return $this->json(['query' =>  $query, 'suggestions' => $levels, 'data' => $levels]);
    }

}