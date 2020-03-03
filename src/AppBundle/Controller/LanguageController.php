<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Language;
use AppBundle\Form\Filter\LanguageFilterType;
use AppBundle\Form\LanguageType;
use AppBundle\Manager\LanguageManager;
use AppBundle\Repository\Doctrine\LanguageDoctrineRepository;
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
 * Class LanguageController
 * @package AppBundle\Controller
 *
 * @Route("/admin/language", name="app_admin.language_")
 */
class LanguageController extends AbstractController
{
    /**
     * @Route("/",name="index", methods={"GET"})
     *
     * @param Request $request
     * @param LanguageDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function IndexAction(Request $request, LanguageDoctrineRepository $repository, PaginatorInterface $paginator, FilterBuilderUpdaterInterface $filterBuilderUpdater)
    {
        $qb =  $repository->getIndexQueryBuilder();

        $form = $this->createForm(LanguageFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('language/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @param Request $request
     * @param LanguageManager $languageManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, LanguageManager $languageManager)
    {
        $language = $languageManager->new();
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $languageManager->create($language);
            $this->addFlash('success', 'La langue a été ajoutée avec succès.');

            return $this->redirectToRoute('app_admin.language_index');
        }

        return $this->render('language/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Language $language
     * @param LanguageManager $languageManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Language $language, LanguageManager $languageManager)
    {
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $languageManager->update($language);

            $this->addFlash('success', 'La language été modifiée avec succès.');

            return $this->redirectToRoute('app_admin.language_edit', array('id' => $language->getId()));
        }

        return $this->render('language/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     * @param LanguageDoctrineRepository $languageDoctrineRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocomplete(LanguageDoctrineRepository $languageDoctrineRepository, Request $request)
    {
        $query = $request->query->get('query');

        $languages = $languageDoctrineRepository->findLikeQuery($query);
        $languages = array_map(function($language){
            return $language->getLabel();
        }, $languages);

        $languages = array_unique($languages);
        $languages = array_values($languages);

        return $this->json(['query' =>  $query, 'suggestions' => $languages, 'data' => $languages]);
    }

    /**
     * @Route("/autocompleteS2", name="autocompleteS2")
     *
     * @param LanguageDoctrineRepository $repository
     * @param Request $request
     * @return Response
     */
    public function autocompleteS2(LanguageDoctrineRepository $repository, Request $request)
    {
        $query = $request->query->get('q');

        $languages = $repository->getIndexQueryBuilder()
            ->andWhere('l.label LIKE :query ')
            ->andWhere('l.obsolete = 0')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult()
        ;

        $data = [];
        foreach ($languages as $language)
        {
            $data[] = ['id' => $language->getId(), 'text' => $language->getLabel()];
        }
        return $this->json($data);
    }
}