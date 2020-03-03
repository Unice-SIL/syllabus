<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Domain;
use AppBundle\Entity\Structure;
use AppBundle\Form\DomainType;
use AppBundle\Form\Filter\DomainFilterType;
use AppBundle\Manager\DomainManager;
use AppBundle\Repository\Doctrine\DomainDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DomainController
 * @package AppBundle\Controller
 *
 * @Route("/admin/domain", name="app_admin_domain_")
 */
class DomainController extends AbstractController
{

    /**
     * @Route("/",name="index", methods={"GET"})
     *
     * @param Request $request
     * @param DomainDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(Request $request, DomainDoctrineRepository $repository, PaginatorInterface $paginator,
                                FilterBuilderUpdaterInterface $filterBuilderUpdater)
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
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @param Request $request
     * @param DomainManager $domainManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, DomainManager $domainManager)
    {
        $domain = $domainManager->new();
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $domainManager->create($domain);

            $this->addFlash('success', 'Le domaine a été ajoutée avec succès.');

            return $this->redirectToRoute('app_admin_domain_index');
        }

        return $this->render('domain/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Domain $domain
     * @param DomainManager $domainManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Domain $domain, DomainManager $domainManager)
    {
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $domainManager->update($domain);

            $this->addFlash('success', 'Le domaine été modifié avec succès.');

            return $this->redirectToRoute('app_admin_domain_edit', array('id' => $domain->getId()));
        }

        return $this->render('domain/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     * @param DomainDoctrineRepository $domainDoctrineRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function autocomplete(DomainDoctrineRepository $domainDoctrineRepository, Request $request)
    {
        $query = $request->query->get('query');

        $domains = $domainDoctrineRepository->findLikeQuery($query);
        $domains = array_map(function($domain){
            return $domain->getLabel();
        }, $domains);

        $domains = array_unique($domains);
        $domains = array_values($domains);

        return $this->json(['query' =>  $query, 'suggestions' => $domains, 'data' => $domains]);
    }

    /**
     * @Route("/autocompleteS2/{structure}", name="autocompleteS2")
     *
     * @param Structure $structure
     * @return Response
     */
    public function autocompleteS2(Structure $structure)
    {
        $data = [];
        $domains = $structure->getDomains();
        if(!empty($domains)){
            foreach ($domains as $domain){
                $data[] = ['id' => $domain->getId(), 'text' => $domain->getLabel()];
            }
        }
        return $this->json($data);
    }
}