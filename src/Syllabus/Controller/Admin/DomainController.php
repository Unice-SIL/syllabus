<?php


namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Entity\Domain;
use App\Syllabus\Form\DomainType;
use App\Syllabus\Form\Filter\DomainFilterType;
use App\Syllabus\Manager\DomainManager;
use App\Syllabus\Repository\Doctrine\DomainDoctrineRepository;
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
 * Class DomainController
 * @package App\Syllabus\Controller\Admin
 *
 * @Route("/domain", name="app.admin.domain.")
 * @Security("is_granted('ROLE_ADMIN_DOMAIN')")
 */
class DomainController extends AbstractController
{

    /**
     * @Route("/",name="index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_DOMAIN_LIST')")
     *
     * @param Request $request
     * @param DomainDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        DomainDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    ): Response
    {
        $qb =  $repository->getIndexQueryBuilder();

        $form = $this->createForm(DomainFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('domain/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_DOMAIN_CREATE')")
     *
     * @param Request $request
     * @param DomainManager $domainManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, DomainManager $domainManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $domain = $domainManager->new();
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $domainManager->create($domain);

            $this->addFlash('success', $translator->trans('admin.domain.flashbag.new'));

            return $this->redirectToRoute('app.admin.domain.index');
        }

        return $this->render('domain/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_DOMAIN_UPDATE')")
     *
     * @param Request $request
     * @param Domain $domain
     * @param DomainManager $domainManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Domain $domain, DomainManager $domainManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $domainManager->update($domain);

            $this->addFlash('success', $translator->trans('admin.domain.flashbag.edit'));

            return $this->redirectToRoute('app.admin.domain.edit', array('id' => $domain->getId()));
        }

        return $this->render('domain/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}