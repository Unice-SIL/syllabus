<?php


namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Entity\Language;
use App\Syllabus\Form\Filter\LanguageFilterType;
use App\Syllabus\Form\LanguageType;
use App\Syllabus\Manager\LanguageManager;
use App\Syllabus\Repository\Doctrine\LanguageDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class LanguageController
 * @package App\Syllabus\Controller
 *
 * @Route("/language", name="app.admin.language.")
 * @Security("has_role('ROLE_ADMIN_LANGUAGE')")
 */
class LanguageController extends AbstractController
{
    /**
     * @Route("/",name="index", methods={"GET"})
     * @Security("has_role('ROLE_ADMIN_LANGUAGE_LIST')")
     *
     * @param Request $request
     * @param LanguageDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function IndexAction(
        Request $request,
        LanguageDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
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
     * @Security("has_role('ROLE_ADMIN_LANGUAGE_CREATE')")
     * @param Request $request
     * @param LanguageManager $languageManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, LanguageManager $languageManager, TranslatorInterface $translator)
    {
        $language = $languageManager->new();
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $languageManager->create($language);
            $this->addFlash('success', $translator->trans('admin.language.flashbag.new'));

            return $this->redirectToRoute('app.admin.language.index');
        }

        return $this->render('language/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_LANGUAGE_UPDATE')")
     * @param Request $request
     * @param Language $language
     * @param LanguageManager $languageManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Language $language, LanguageManager $languageManager, TranslatorInterface $translator)
    {
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $languageManager->update($language);

            $this->addFlash('success', $translator->trans('admin.language.flashbag.edit'));

            return $this->redirectToRoute('app.admin.language.edit', array('id' => $language->getId()));
        }

        return $this->render('language/edit.html.twig', array(
            'form' => $form->createView(),
        ));
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