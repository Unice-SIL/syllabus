<?php


namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Entity\Period;
use App\Syllabus\Form\Filter\PeriodFilterType;
use App\Syllabus\Form\PeriodType;
use App\Syllabus\Manager\PeriodManager;
use App\Syllabus\Repository\Doctrine\PeriodDoctrineRepository;
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
 * @package App\Syllabus\Controller
 *
 * @Route("/period", name="app.admin.period.")
 * @Security("is_granted('ROLE_ADMIN_PERIOD')")
 */
class PeriodController extends AbstractController
{
    /**
     * @Route("/",name="index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_PERIOD_LIST')")
     *
     * @param Request $request
     * @param PeriodDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        PeriodDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {
        $qb =  $repository->getIndexQueryBuilder();

        $form = $this->createForm(PeriodFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('period/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_PERIOD_CREATE')")
     *
     * @param Request $request
     * @param PeriodManager $periodManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, PeriodManager $periodManager, TranslatorInterface $translator)
    {
        $period = $periodManager->new();
        $form = $this->createForm(PeriodType::class, $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $periodManager->create($period);

            $this->addFlash('success', $translator->trans('admin.period.flashbag.new'));

            return $this->redirectToRoute('app.admin.period.index');
        }

        return $this->render('period/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_PERIOD_UPDATE')")
     *
     * @param Request $request
     * @param Period $period
     * @param PeriodManager $periodManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Period $period, PeriodManager $periodManager, TranslatorInterface $translator)
    {
        $form = $this->createForm(PeriodType::class, $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $periodManager->update($period);

            $this->addFlash('success', $translator->trans('admin.period.flashbag.edit'));

            return $this->redirectToRoute('app.admin.period.edit', array('id' => $period->getId()));
        }

        return $this->render('period/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}