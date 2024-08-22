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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class LanguageController
 * @package App\Syllabus\Controller
 *
 * @Security("is_granted('ROLE_ADMIN_LANGUAGE')")
 */
#[Route(path: '/language', name: 'app.admin.language.')]
class LanguageController extends AbstractController
{
    /**
     * @Security("is_granted('ROLE_ADMIN_LANGUAGE_LIST')")
     *
     */
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function IndexAction(
        Request $request,
        LanguageDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    ): Response
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
     * @Security("is_granted('ROLE_ADMIN_LANGUAGE_CREATE')")
     */
    #[Route(path: '/new', name: 'new', methods: ['GET', 'POST'])]
    public function newAction(Request $request, LanguageManager $languageManager, TranslatorInterface $translator): RedirectResponse|Response
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
     * @Security("is_granted('ROLE_ADMIN_LANGUAGE_UPDATE')")
     */
    #[Route(path: '/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, Language $language, LanguageManager $languageManager, TranslatorInterface $translator): RedirectResponse|Response
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

    
    #[Route(path: '/autocompleteS2', name: 'autocompleteS2')]
    public function autocompleteS2(LanguageDoctrineRepository $repository, Request $request): Response
    {
        $parameters = $request->query->all();
        $query = $parameters['q'];

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