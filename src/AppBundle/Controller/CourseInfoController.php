<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\DuplicateCourseInfoType;
use AppBundle\Form\Filter\CourseInfoFilterType;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\Doctrine\ActivityDoctrineRepository;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class CourseInfoController
 * @package AppBundle\Controller
 * @Route("/admin/syllabus", name="app_admin_course_info_")
 */
class CourseInfoController extends Controller
{
    /**
     * @Route("/", name="index")
     *
     * @param Request $request
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param CourseInfoManager $courseInfoManager
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(
        Request $request,
        CourseInfoDoctrineRepository $courseInfoDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater,
        CourseInfoManager $courseInfoManager,
        EntityManagerInterface $em
    )
    {

        $qb = $courseInfoDoctrineRepository->getIndexQueryBuilder();

        $form = $this->createForm(CourseInfoFilterType::class);
        $duplicationForm = $this->createForm(DuplicateCourseInfoType::class);
        $duplicationForm->handleRequest($request);

        $isFormValid = true;
        if ($duplicationForm->isSubmitted()) {

            if ($duplicationForm->isValid()) {

                $data = $duplicationForm->getData();
                $from = $data['from'];
                $to = $data['to'];

                $errors = $courseInfoManager->duplicate($from, $to->getId(), CourseInfoManager::DUPLICATION_CONTEXTE_MANUALLY);

                if (count($errors) <= 0) {

                    $this->addFlash('success', 'La duplication a été réalisée avec succès');
                    $em->flush();

                    return $this->redirectToRoute('app_admin_course_info_index');
                }

                foreach ($errors as $error) {
                    $this->addFlash('danger', $error);
                }

                return $this->redirectToRoute('app_admin_course_info_index');
            }

            $isFormValid = false;

        }

        if ($request->query->has($form->getName())) {

            $form->submit($request->query->get($form->getName()));

            $filterBuilderUpdater->setParts([
                '__root__'    => 'ci',
                'ci.course'      => 'c',
                'ci.structure' => 's',
                'ci.year' => 'y',
            ]);

            $filterBuilderUpdater->addFilterConditions($form, $qb);

        }

        $pagination = $this->get('knp_paginator')->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('course_info/admin/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
            'duplicationForm' => $duplicationForm->createView(),
            'isFormValid' => $isFormValid
        ));
    }

    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "ci.title|c.etbId|c.type|y.label|s.label"})
     */
    public function autocomplete(CourseInfoDoctrineRepository $courseInfoDoctrineRepository, Request $request, $field)
    {
        $query = $request->query->get('query');

        $courseInfos = $courseInfoDoctrineRepository->findLikeQuery($query, $field);


        $suggestions = array_map(function($courseInfo) use ($field){

            switch ($field) {
                case 'c.etbId':
                    return $courseInfo->getCourse()->getEtbId();
                case 'ci.title':
                    return $courseInfo->getTitle();
                case 'c.type':
                    return $courseInfo->getCourse()->getType();
                case 'y.label':
                    return $courseInfo->getYear()->getLabel();
                case 's.label':
                    return $courseInfo->getStructure()->getLabel();
            }

        }, $courseInfos);

        $suggestions = array_unique($suggestions);

        return $this->json(['query' =>  $query, 'suggestions' => $suggestions, 'data' => $suggestions]);
    }

    /**
     * @Route("/autocompleteS2", name="autocompleteS2", methods={"GET"})
     */
    public function autocompleteS2(CourseInfoDoctrineRepository $courseInfoDoctrineRepository, Request $request)
    {
        $query = $request->query->get('q');

        $field = $request->query->get('field_name');
        switch ($field) {
            default:
                $searchField = 'c.etbId';
                break;
        }

        $courseInfos = $courseInfoDoctrineRepository->findLikeQuery($query, $searchField);

        $data = array_map(function ($ci) use ($request) {
            if ($ci->getId() == $request->query->get('fromId')) {
                return false;
            }
            return ['id' => $ci->getId(), 'text' => $ci->getCourse()->getEtbId() . ' ' . $ci->getYear()->getLabel()];
        }, $courseInfos);

        return $this->json($data);
    }

}
