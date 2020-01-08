<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CourseInfo;
use AppBundle\Form\Filter\CourseInfoFilterType;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\Doctrine\ActivityDoctrineRepository;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, CourseInfoDoctrineRepository $courseInfoDoctrineRepository, FilterBuilderUpdaterInterface $filterBuilderUpdater)
    {

        $qb = $courseInfoDoctrineRepository->getIndexQueryBuilder();

        $form = $this->createForm(CourseInfoFilterType::class);

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
        ));
    }

    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "ci.title|c.etbId|c.type|y.label|s.label"})
     */
    public function autocomplete(CourseInfoDoctrineRepository $courseInfoDoctrineRepository, Request $request, $field)
    {
        $query = $request->query->get('query');

        $courses = $courseInfoDoctrineRepository->findLikeQuery($query, $field);
        $courses = array_map(function($course) use ($field){

            switch ($field) {
                case 'c.etbId':
                    return $course->getCourse()->getEtbId();
                case 'ci.title':
                    return $course->getTitle();
                case 'c.type':
                    return $course->getCourse()->getType();
                case 'y.label':
                    return $course->getYear()->getLabel();
                case 's.label':
                    return $course->getStructure()->getLabel();
            }

        }, $courses);


        return $this->json(['query' =>  $query, 'suggestions' => $courses, 'data' => $courses]);
    }

}
