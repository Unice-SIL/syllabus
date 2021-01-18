<?php

namespace App\Syllabus\Controller;

use App\Syllabus\Entity\Course;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Form\Course\AddChildrenCourseType;
use App\Syllabus\Form\Course\AddParentCourseType;
use App\Syllabus\Form\Course\RemoveChildrenCourseType;
use App\Syllabus\Form\Course\RemoveParentCourseType;
use App\Syllabus\Form\CourseInfoType;
use App\Syllabus\Form\CourseType;
use App\Syllabus\Form\Filter\CourseFilterType;
use App\Syllabus\Manager\CourseManager;
use App\Syllabus\Repository\Doctrine\CourseDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

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
        $form = $this->createForm(CourseFilterType::class, null);

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
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, CourseManager $courseManager, TranslatorInterface $translator)
    {
        $course = $courseManager->new();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $courseManager->create($course);

            $this->addFlash('success', $translator->trans('app.controller.course.new'));

            return $this->redirectToRoute('app_admin.course_index');
        }
        return $this->render('course/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Displays a form to edit an existing course entity.
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Course $course
     * @param CourseManager $courseManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Course $course, CourseManager $courseManager, TranslatorInterface $translator)
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseManager->update($course);

            $this->addFlash('success', $translator->trans('app.controller.course.edit'));
            return $this->redirectToRoute('app_admin.course_edit', array('id' => $course->getId()));
        }
        return $this->render('course/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * List the piece of informations of an existing course including a table of associated CourseInfo
     * @Route("/{id}/show", name="show", methods={"GET", "POST"})
     * @Entity("course", expr="repository.findCourseWithCourseInfoAndYear(id)")
     * @param Course $course
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param FormFactoryInterface $formFactory
     * @return Response
     */
    public function showAction(
        Course $course,
        EntityManagerInterface $em,
        Request $request,
        FilterBuilderUpdaterInterface $filterBuilderUpdater,
        FormFactoryInterface $formFactory
    )
    {


        /*===================================================================================================*/
        $removeParentCourseForm = $this->createForm(RemoveParentCourseType::class);
        $removeParentCourseForm->handleRequest($request);

        if ($removeParentCourseForm->isSubmitted() and $removeParentCourseForm->isValid()) {

            $courseToRemove = $em->getRepository(Course::class)->find($removeParentCourseForm->getData()['id']);

            $course->removeParent($courseToRemove);

            $em->flush();

            return $this->redirectToRoute('app_admin.course_show', [
                'id' => $course->getId()
            ]);
        }
        /*===================================================================================================*/

        /*===================================================================================================*/
        $removeChildrenCourseForm = $this->createForm(RemoveChildrenCourseType::class);
        $removeChildrenCourseForm->handleRequest($request);

        if ($removeChildrenCourseForm->isSubmitted() and $removeChildrenCourseForm->isValid()) {

            $courseToRemove = $em->getRepository(Course::class)->find($removeChildrenCourseForm->getData()['id']);

            $course->removeChild($courseToRemove);

            $em->flush();

            return $this->redirectToRoute('app_admin.course_show', [
                'id' => $course->getId()
            ]);
        }
        /*===================================================================================================*/

        /*===================================================================================================*/
        $addParentCourseForm = $this->createForm(AddParentCourseType::class, $course);
        $addParentCourseForm->handleRequest($request);
        $addChildrenCourseForm = $this->createForm(AddChildrenCourseType::class, $course);
        $addChildrenCourseForm->handleRequest($request);

        if (
            ($addParentCourseForm->isSubmitted() and $addParentCourseForm->isValid())
            or ($addChildrenCourseForm->isSubmitted() and $addChildrenCourseForm->isValid())
        ) {

            $em->flush();

            return $this->redirectToRoute('app_admin.course_show', [
                'id' => $course->getId()
            ]);
        }
        /*===================================================================================================*/

        $modelForm = $this->createForm(CourseFilterType::class);
        $modelName = $modelForm->getName();

        $filterParentForm = $formFactory->createNamed($modelName . '_parent', CourseFilterType::class);
        $parentQb = $em->getRepository(Course::class)->getParentCoursesQbByCourse($course);

        if ($request->query->has($filterParentForm->getName())) {
            $filterParentForm->submit($request->query->get($filterParentForm->getName()));
            $filterBuilderUpdater->addFilterConditions($filterParentForm, $parentQb);
        }

        $parentPagination = $this->get('knp_paginator')->paginate(
            $parentQb,
            $request->query->getInt('parents_page', 1),
            10,
            ['pageParameterName' => 'parents_page']
        );

        $filterChildrenForm = $formFactory->createNamed($modelName . '_children', CourseFilterType::class);
        $childrenQb = $em->getRepository(Course::class)->getChildrenCoursesQbByCourse($course);

        if ($request->query->has($filterChildrenForm->getName())) {
            $filterChildrenForm->submit($request->query->get($filterChildrenForm->getName()));
            $filterBuilderUpdater->addFilterConditions($filterChildrenForm, $childrenQb);
        }

        $childrenPagination = $this->get('knp_paginator')->paginate(
            $childrenQb,
            $request->query->getInt('children_page', 1),
            10,
            ['pageParameterName' => 'children_page']
        );

        return $this->render('course/show.html.twig', [
            'course' => $course,
            'addParentCourseForm' => $addParentCourseForm->createView(),
            'addChildrenCourseForm' => $addChildrenCourseForm->createView(),
            'removeParentCourseForm' => $removeParentCourseForm,
            'removeChildrenCourseForm' => $removeChildrenCourseForm,
            'parentPagination' => $parentPagination,
            'childrenPagination' => $childrenPagination,
            'filterParentForm' => $filterParentForm->createView(),
            'filterChildrenForm' => $filterChildrenForm->createView(),
        ]);
    }

    /**
     * Creates a course-info for the given course
     * @Route("/{id}/new-course-info", name="new_course_info", methods={"GET", "POST"})
     * @param Course $course
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function newCourseInfo(Course $course, Request $request, EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $courseInfo = new CourseInfo();
        $courseInfo->setCourse($course);
        $courseInfoForm = $this->createForm(CourseInfoType::class, $courseInfo, ['validation_groups' => ['new']]);

        $courseInfoForm->handleRequest($request);

        if ($courseInfoForm->isSubmitted() and $courseInfoForm->isValid()) {
            $course->addCourseInfo($courseInfo);
            $em->flush();

            $this->addFlash('success', $translator->trans('app.controller.course.add_syllabus'));

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
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public function autocompleteS2(CourseDoctrineRepository $courseDoctrineRepository, Request $request)
    {
        $query = $request->query->get('q');

        $exceptions = [];
        if ($courseId = $request->query->get('course_id')) {
            $exceptions = ['id' => [$courseId]];
        }

        $courses = $courseDoctrineRepository->findLikeQuery($query, 'code', $exceptions);

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
     * @return JsonResponse
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