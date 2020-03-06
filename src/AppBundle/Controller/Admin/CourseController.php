<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Course;
use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfoType;
use AppBundle\Form\CourseType;
use AppBundle\Form\Filter\CourseFilterType;
use AppBundle\Manager\CourseManager;
use AppBundle\Repository\Doctrine\CourseDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseController
 * @package AppBundle\Controller
 *
 * @Route("/course", name="app_admin.course_")
 */
class CourseController extends Controller
{
    /**
     * @Route("/", name="index")
     *
     * @param Request $request
     * @param CourseDoctrineRepository $courseDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        CourseDoctrineRepository $courseDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {
        $qb = $courseDoctrineRepository->getIndexQueryBuilder();
        $form = $this->createForm(CourseFilterType::class, null,  ['context'=> 'course']);

        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));
            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $this->get('knp_paginator')->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('course/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @param CourseManager $courseManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request, CourseManager $courseManager)
    {
        $course = $courseManager->new();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $courseManager->create($course);

            $this->addFlash('success', 'Le cours a été enregistré avec succès');

            return $this->redirectToRoute('app_admin.course_index');
        }
        return $this->render('course/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Displays a form to edit an existing course entity.
     *
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Course $course
     * @param CourseManager $courseManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Course $course, CourseManager $courseManager)
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseManager->update($course);

            $this->addFlash('success', 'Le cours a été modifié avec succès.');
            return $this->redirectToRoute('app_admin.course_edit', array('id' => $course->getId()));
        }
        return $this->render('course/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * List the piece of informations of an existing course including a table of associated CourseInfo
     * @Route("/{id}/show", name="show", methods={"GET"})
     * @Entity("course", expr="repository.findCourseWithCourseInfoAndYear(id)")
     * @param string $id
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function showAction(Course $course, EntityManagerInterface $em)
    {

        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * Creates a course-info for the given course
     * @Route("/{id}/new-course-info", name="new_course_info", methods={"GET", "POST"})
     * @param Course $course
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function newCourseInfo(Course $course, Request $request, EntityManagerInterface $em)
    {
        $courseInfo = new CourseInfo();
        $courseInfo->setCourse($course);
        $courseInfoForm = $this->createForm(CourseInfoType::class, $courseInfo, ['validation_groups' => ['new']]);

        $courseInfoForm->handleRequest($request);

        if ($courseInfoForm->isSubmitted() and $courseInfoForm->isValid()) {
            $course->addCourseInfo($courseInfo);
            $em->flush();

            $this->addFlash('success', 'Le syllabus a bien été ajouté au cours.');

            return $this->redirectToRoute('app_admin.course_show', ['id' => $course->getId()]);
        }

        return $this->render('course/new_course_info.html.twig', [
            'form' => $courseInfoForm->createView(),
            'course' => $course,
        ]);
    }

    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "code|title"})
     *
     * @param CourseDoctrineRepository $courseDoctrineRepository
     * @param Request $request
     * @param $field
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function autocomplete(CourseDoctrineRepository $courseDoctrineRepository, Request $request, $field)
    {
        $query = $request->query->get('query');

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $courses = $courseDoctrineRepository->findLikeQuery($query, $field);

        $courses = array_map(function($c) use ($field, $propertyAccessor){
            return $propertyAccessor->getValue($c, $field);
        }, $courses);

        $courses = array_unique($courses);

        return $this->json(['query' =>  $query, 'suggestions' => $courses, 'data' => $courses]);
    }

    /**
     * @Route("/autocompleteS2", name="autocompleteS2", methods={"GET"})
     *
     * @param CourseDoctrineRepository $courseDoctrineRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function autocompleteS2(CourseDoctrineRepository $courseDoctrineRepository, Request $request)
    {
        $query = $request->query->get('q');
        $courses = $courseDoctrineRepository->findLikeQuery($query, 'code');

        $data = array_map(function ($c) use ($request) {

            if (strtolower($c->getCode()) == strtolower($request->query->get('code'))) {
                return false;
            }
            return ['id' => $c->getId(), 'text' => $c->getCode()];
        }, $courses);

        return $this->json($data);
    }

    /**
     * @Route("/autocompleteS3", name="autocompleteS3", methods={"GET"})
     *
     * @param CourseManager $courseManager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function autocompleteS3(CourseManager $courseManager)
    {
        $results = $courseManager->findAll();
        $courses = [];
        foreach($results as $course)
        {
            $courses[] = ['id' => $course->getId(), 'text' => $course->getCode()];
        }

        return $this->json($courses);
    }

}