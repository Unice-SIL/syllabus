<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseInfoField;
use AppBundle\Form\CourseInfo\CourseInfoAdminType;
use AppBundle\Form\CourseInfo\DuplicateCourseInfoType;
use AppBundle\Form\CourseInfo\ImportType;
use AppBundle\Form\Filter\CourseInfoFilterType;
use AppBundle\Helper\Report\Report;
use AppBundle\Helper\Report\ReportingHelper;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Parser\CourseInfoCsvParser;
use AppBundle\Repository\Doctrine\CourseDoctrineRepository;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Exception;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseInfoController
 * @package AppBundle\Controller
 * @Route("/admin/syllabus", name="app_admin_course_info_")
 */
class CourseInfoController extends Controller
{
    /**
     * @Route("/", name="index")
     * @param Request $request
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param CourseInfoManager $courseInfoManager
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     * @throws \Exception
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

                /** @var  CourseInfo $to */
                $to = $data['to']->getCodeYear(true);


                /** @var Report $report */
                $report = $courseInfoManager->duplicate($from, $to, CourseInfoManager::DUPLICATION_CONTEXTE_MANUALLY);

                if (!$report->hasMessages() and !$report->hasLines()) {

                    $this->addFlash('success', 'La duplication a été réalisée avec succès');
                    $em->flush();

                    return $this->redirectToRoute('app_admin_course_info_index');
                }

                foreach ($report->getMessages() as $message) {
                    $this->addFlash($message->getType(), $message->getContent());
                }

                foreach ($report->getLines() as $line) {
                    foreach ($line->getComments() as $comment) {
                        $this->addFlash('danger', $comment);
                    }
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
     * @Route("/new", name="new")
     *
     * @param Request $request
     * @param CourseInfoManager $courseInfoManager
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, CourseInfoManager $courseInfoManager, EntityManagerInterface $em)
    {
        $courseInfo = $courseInfoManager->createOne();

        $form = $this->createForm(CourseInfoAdminType::class, $courseInfo, ['validation_groups' => ['Default', 'new']]);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($courseInfo);
            $em->flush();

            $this->addFlash('success', 'Le syllabus a été crée avec succès');

            return $this->redirectToRoute('app_admin_course_info_index');
        }

        return $this->render('course_info/admin/new.html.twig', ['form' => $form->createView()]);
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
            return $this->redirectToRoute('app_admin_course_info_duplicate_syllabus_from_file');

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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
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
     * @param CourseDoctrineRepository $courseDoctrineRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
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

    /**
     * @Route("/import-mcc", name="import_mcc", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param CourseInfoManager $courseInfoManager
     * @param CourseInfoCsvParser $courseInfoCsvParser
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function importCsv(Request $request, EntityManagerInterface $em, CourseInfoManager $courseInfoManager, CourseInfoCsvParser $courseInfoCsvParser)
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid())
        {

            $courseInfos = $courseInfoCsvParser->parse($form->getData()['file']->getPathName(), [
                'allow_extra_field' => true,
                'allow_less_field' => true,
                'report' => ReportingHelper::createReport('Parsing du Fichier Csv'),
            ]);

            $courseInfoFields = $em->getRepository(CourseInfoField::class)->findByImport(true);
            $fieldsToUpdate = array_map(function ($courseInfoField) {
                return $courseInfoField->getField();
                }, $courseInfoFields);

            $validationReport = ReportingHelper::createReport('Insertion en base de données');

            foreach ($courseInfos as $lineIdReport => $courseInfo) {

                $validationReport = $courseInfoManager->updateIfExistsOrCreate($courseInfo, $fieldsToUpdate, [
                    'flush' => true,
                    'find_by_parameters' => [
                        'course' => $courseInfo->getCourse(),
                        'year' => $courseInfo->getYear(),
                    ],
                    'lineIdReport' => $lineIdReport,
                    'report' => ReportingHelper::createReport('Insertion en base de données'),
                ]);


            }

            $validationReport->finishReport(count($courseInfos));
            $request->getSession()->set('parsingCsvReport', $courseInfoCsvParser->getReport());
            $request->getSession()->set('validationReport', $validationReport);
            return $this->redirectToRoute('app_admin_course_info_import_mcc');

        }

        return $this->render('course_info/admin/import_mcc.html.twig', [
            'form' => $form->createView(),
            'parsingCsvReport' => $request->getSession()->remove('parsingCsvReport'),
            'validationReport' => $request->getSession()->remove('validationReport'),
        ]);
    }

}
