<?php

namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Course;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Form\CourseInfo\CourseInfoAdminType;
use App\Syllabus\Form\CourseInfo\DuplicateCourseInfoType;
use App\Syllabus\Form\CourseInfo\ImportType;
use App\Syllabus\Form\CourseInfoType;
use App\Syllabus\Form\Filter\CourseInfoFilterType;
use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Manager\CourseInfoManager;
use App\Syllabus\Manager\StatisticSyllabusManager;
use App\Syllabus\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class CourseInfoController
 * @package App\Syllabus\Controller
 * @Route("/syllabus", name="app.admin.course_info.")
 */
class CourseInfoController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param Request $request
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param CourseInfoManager $courseInfoManager
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @param PaginatorInterface $paginator
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function indexAction(
        Request $request,
        CourseInfoDoctrineRepository $courseInfoDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater,
        CourseInfoManager $courseInfoManager,
        EntityManagerInterface $em,
        TranslatorInterface $translator,
        PaginatorInterface $paginator
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

                /** @var  CourseInfo $to */
                $to = $data['to']->getCodeYear(true);


                /** @var Report $report */
                $report = $courseInfoManager->duplicate($from, $to, CourseInfoManager::DUPLICATION_CONTEXTE_MANUALLY);

                if (!$report->hasMessages() and !$report->hasLines()) {

                    $this->addFlash('success', $translator->trans('admin.course_info.flashbag.duplicate'));
                    $em->flush();

                    return $this->redirectToRoute('app.admin.course_info.index');
                }

                foreach ($report->getMessages() as $message) {
                    $this->addFlash($message->getType(), $message->getContent());
                }

                foreach ($report->getLines() as $line) {
                    foreach ($line->getComments() as $comment) {
                        $this->addFlash('danger', $comment);
                    }
                }

                return $this->redirectToRoute('app.admin_course.info.index');
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

        $pagination = $paginator->paginate(
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
     * @Route("/new", name="new")
     *
     * @param Request $request
     * @param CourseInfoManager $courseInfoManager
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function newAction(Request $request, CourseInfoManager $courseInfoManager, EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $courseInfo = $courseInfoManager->new();

        $form = $this->createForm(CourseInfoAdminType::class, $courseInfo, ['validation_groups' => ['Default', 'new']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $courseInfoManager->update($courseInfo);

            $this->addFlash('success', $translator->trans('admin.course_info.flashbag.new'));
            return $this->redirectToRoute('app.admin.course_info.index');
        }
        return $this->render('course_info/admin/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Update an existing CourseInfo
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function edit(CourseInfo $courseInfo, Request $request, EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $form = $this->createForm(CourseInfoType::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            $em->flush();

            $this->addFlash('success', $translator->trans('admin.course_info.flashbag.edit'));

            return $this->redirectToRoute('app.admin.course_info.edit', [
                'id' => $courseInfo->getId(),
            ]);
        }

        return $this->render('course_info/admin/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Course info published list
     *
     * @Route("/published/{year}", name="published", methods={"GET", "POST"})
     *
     * @param $year
     * @param Request $request
     * @param StatisticSyllabusManager $statisticSyllabusManager
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function published($year, Request $request,StatisticSyllabusManager $statisticSyllabusManager,
                              PaginatorInterface $paginator)
    {
        $pagination = $paginator->paginate(
            $statisticSyllabusManager->findSyllabusPublished($year),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('course_info/published/published.html.twig', array(
            'pagination' => $pagination
        ));

    }

    /**
     * Course info being filled list
     *
     * @Route("/being-filled/{year}", name="being_filled", methods={"GET", "POST"})
     *
     * @param $year
     * @param Request $request
     * @param StatisticSyllabusManager $statisticSyllabusManager
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function beingFilled($year, Request $request,StatisticSyllabusManager $statisticSyllabusManager,
                              PaginatorInterface $paginator)
    {
        $pagination = $paginator->paginate(
            $statisticSyllabusManager->findSyllabusBeingFilled($year),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('course_info/being_filled/being_filled.html.twig', array(
            'pagination' => $pagination
        ));

    }

    /**
     * @Route("/duplicate-syllabus-from-file", name="duplicate_syllabus_from_file")
     *
     * @param CourseInfoManager $courseInfoManager
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function duplicateSyllabusFromFileAction(CourseInfoManager $courseInfoManager, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid())
        {
            $report = $courseInfoManager->duplicateFromFile($form->getData()['file']->getPathName());
            $em->flush();

            $request->getSession()->set('duplicateSyllabus', $report);
            return $this->redirectToRoute('app.admin_course.info.duplicate_syllabus_from_file');
        }
        return $this->render('course_info/admin/duplicate_syllabus_from_file.html.twig', [
            'form' => $form->createView(),
            'report' => $request->getSession()->remove('duplicateSyllabus')
        ]);

    }

    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "ci.title|c.code|c.type|y.label|s.label"})
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param Request $request
     * @param $field
     * @return JsonResponse
     */
    public function autocomplete(CourseInfoDoctrineRepository $courseInfoDoctrineRepository, Request $request, $field)
    {
        $query = $request->query->get('query');

        $courseInfos = $courseInfoDoctrineRepository->findLikeQuery($query, $field);

        $suggestions = array_map(function($courseInfo) use ($field){

            switch ($field) {
                case 'c.code':
                    return $courseInfo->getCourse()->getCode();
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
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteS2(CourseInfoDoctrineRepository $courseInfoDoctrineRepository, Request $request)
    {
        $query = $request->query->get('q');
        $field = $request->query->get('field_name');

        switch ($field) {
            default:
                $searchField = 'c.code';
                break;
        }

        $courseInfos = $courseInfoDoctrineRepository->findLikeQuery($query, $searchField);

        $data = array_map(function ($ci) use ($request) {
            if ($fromCodeYear = $request->query->get('fromCodeYear') and $ci->getCodeYear(true) == $fromCodeYear) {
                return false;
            }
            return ['id' => $ci->getId(), 'text' => $ci->getCodeYear()];
        }, $courseInfos);

        return $this->json($data);
    }

    /**
     * @Route("/autocompleteS3", name="autocompleteS3", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function autocompleteS3()
    {
        $results = $this->getDoctrine()->getRepository(Course::class)->findAll();
        $courses = [];
        foreach($results as $course)
        {
            $courses[] = ['id' => $course->getId(), 'text' => $course->getCode()];
        }

        return $this->json($courses);
    }

}
