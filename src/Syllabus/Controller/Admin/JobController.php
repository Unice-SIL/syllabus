<?php

namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Job;
use App\Syllabus\Form\Filter\JobFilterType;
use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Repository\Doctrine\JobDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Job controller.
 *
 * @Route("/job", name="app.admin.job.")
 * @Security("is_granted('ROLE_ADMIN_JOB')")
 *
 */
class JobController extends AbstractController
{
    /**
     * Lists all jobs entities.
     *
     * @Route("/", name="index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_JOB_LIST')")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param JobDoctrineRepository $jobDoctrineRepository
     * @return Response
     */
    public function indexAction(
        Request $request,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater,
        JobDoctrineRepository $jobDoctrineRepository
    )
    {
        $qb =  $jobDoctrineRepository->getIndexQueryBuilder();

        $form = $this->createForm(JobFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        $deleteFormsView = [];
        foreach ($pagination as $job) {
            $deleteFormsView[$job->getId()] = $this->createDeleteForm($job)->createView();
        }

        return $this->render('job/index.html.twig', array(
            'pagination' => $pagination,
            'deleteFormsView' => $deleteFormsView,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new job entity.
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_JOB_CREATE')")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $job = new Job();
        $form = $this->createForm('App\Syllabus\Form\JobType', $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return $this->redirectToRoute('app.admin.job.index', array('id' => $job->getId()));
        }

        return $this->render('job/new.html.twig', array(
            'job' => $job,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing job entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ADMIN_JOB_UPDATE')")
     *
     * @param Request $request
     * @param Job $job
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Job $job)
    {
        $deleteForm = $this->createDeleteForm($job);
        $editForm = $this->createForm('App\Syllabus\Form\JobType', $job);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app.admin.job.edit', array('id' => $job->getId()));
        }

        return $this->render('job/edit.html.twig', array(
            'job' => $job,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays the report for the given job entity.
     *
     * @Route("/{id}/report", name="report", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_JOB_REPORT')")
     *
     * @param Request $request
     * @param Job $job
     * @return RedirectResponse|Response
     */
    public function reportAction(Request $request, Job $job)
    {
        if ($job->getLastStatus() === \App\Syllabus\Constant\Job::STATUS_IN_PROGRESS) {
            return $this->redirectToRoute('app.admin.job.index');
        }

        $report = unserialize($job->getReport());
        $string = null;

        if (!$report instanceof Report) {
            $string = $report;
            $report = null;
        }

        return $this->render('job/report.html.twig', array(
            'report' => $report,
            'string' => $string,
            'job' => $job
        ));
    }


    /**
     * Deletes a job entity.
     *
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN_JOB_DELETE')")
     *
     * @param Request $request
     * @param Job $job
     * @param TranslatorInterface $translator
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Job $job, TranslatorInterface $translator)
    {
        if ($job->getLastStatus() !== \App\Syllabus\Constant\Job::STATUS_IN_PROGRESS) {

            $form = $this->createDeleteForm($job);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($job);
                $em->flush();
            }
            return $this->redirectToRoute('app.admin.job.index');
        }

        $this->addFlash( 'danger', $translator->trans('admin.job.flashbag.action_in_progress'));
        return $this->redirectToRoute('app.admin.job.index');

    }

    /**
     * @param Job $job
     * @return FormInterface
     */
    private function createDeleteForm(Job $job)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app.admin.job.delete', array('id' => $job->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * @Route("/run-command/{id}", name="run_command", methods={"POST"})
     * @param Request $request
     * @param Job $job
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function runCommandAction(Request $request, Job $job, EntityManagerInterface $em, TranslatorInterface $translator)
    {
        if (!$this->isCsrfTokenValid('job' . $job->getId(), $request->request->all('_token'))) {
            $this->addFlash( 'danger', $translator->trans('admin.job.flashbag.unauthorized_action'));

            return $this->redirectToRoute('app.admin.job.index');
        }

        if ($job->getLastStatus() !== \App\Syllabus\Constant\Job::STATUS_IN_PROGRESS) {
            $job->setImmediately(true);
            $em->flush();
            return $this->redirectToRoute('app.admin.job.index');
        }

        $this->addFlash( 'danger', $translator->trans('admin.job.flashbag.action_in_progress'));

        return $this->redirectToRoute('app.admin.job.index');
    }
}
