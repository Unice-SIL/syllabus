<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cron;
use AppBundle\Form\Filter\CronFilterType;
use AppBundle\Repository\Doctrine\CronDoctrineRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cron controller.
 *
 * @Route("admin/cron", name="app.admin.cron.")
 */
class CronController extends Controller
{
    /**
     * Lists all cron entities.
     *
     * @Route("/", name="index", methods={"GET"})
     * @param Request $request
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param CronDoctrineRepository $cronDoctrineRepository
     * @return Response
     */
    public function indexAction(Request $request, FilterBuilderUpdaterInterface $filterBuilderUpdater, CronDoctrineRepository $cronDoctrineRepository)
    {

        $qb =  $cronDoctrineRepository->getIndexQueryBuilder();

        $form = $this->createForm(CronFilterType::class);

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $this->get('knp_paginator')->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        $deleteFormsView = [];
        foreach ($pagination as $cron) {
            $deleteFormsView[$cron->getId()] = $this->createDeleteForm($cron)->createView();
        }

        return $this->render('cron/index.html.twig', array(
            'pagination' => $pagination,
            'deleteFormsView' => $deleteFormsView,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new cron entity.
     *
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $cron = new Cron();
        $form = $this->createForm('AppBundle\Form\CronType', $cron);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cron);
            $em->flush();

            return $this->redirectToRoute('app.admin.cron.index', array('id' => $cron->getId()));
        }

        return $this->render('cron/new.html.twig', array(
            'cron' => $cron,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cron entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Cron $cron
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Cron $cron)
    {
        $deleteForm = $this->createDeleteForm($cron);
        $editForm = $this->createForm('AppBundle\Form\CronType', $cron);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app.admin.cron.edit', array('id' => $cron->getId()));
        }

        return $this->render('cron/edit.html.twig', array(
            'cron' => $cron,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cron entity.
     *
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Cron $cron
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Cron $cron)
    {
        $form = $this->createDeleteForm($cron);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cron);
            $em->flush();
        }

        return $this->redirectToRoute('app.admin.cron.index');
    }

    /**
     * Creates a form to delete a cron entity.
     *
     * @param Cron $cron The cron entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Cron $cron)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app.admin.cron.delete', array('id' => $cron->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "label"})
     * @param Request $request
     * @param CronDoctrineRepository $cronDoctrineRepository
     * @param $field
     * @return JsonResponse
     */
    public function autocomplete(Request $request, CronDoctrineRepository $cronDoctrineRepository, $field)
    {
        $query = $request->query->get('query', '');

        $crons = $cronDoctrineRepository->findLikeQuery($query, $field);
        $crons = array_map(function(Cron $cron){
            return $cron->getLabel();
        }, $crons);

        $crons = array_unique($crons);
        $crons = array_values($crons);

        return $this->json(['query' =>  $query, 'suggestions' => $crons, 'data' => $crons]);
    }
}
