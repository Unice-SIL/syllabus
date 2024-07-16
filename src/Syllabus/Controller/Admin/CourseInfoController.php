<?php

namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Year;
use App\Syllabus\Form\CourseInfoType;
use App\Syllabus\Manager\StatisticSyllabusManager;
use App\Syllabus\Repository\Doctrine\CourseDoctrineRepository;
use App\Syllabus\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
     * Update an existing CourseInfo
     *
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function edit(CourseInfo $courseInfo, Request $request, EntityManagerInterface $em, TranslatorInterface $translator): RedirectResponse|Response
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
     * @param Year $year
     * @param Request $request
     * @param StatisticSyllabusManager $statisticSyllabusManager
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function published(Year $year, Request $request,StatisticSyllabusManager $statisticSyllabusManager,
                              PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $statisticSyllabusManager->findSyllabusPublished($year->getId()),
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
     * @param Year $year
     * @param Request $request
     * @param StatisticSyllabusManager $statisticSyllabusManager
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function beingFilled(Year $year, Request $request,StatisticSyllabusManager $statisticSyllabusManager,
                                PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $statisticSyllabusManager->findSyllabusBeingFilled($year->getId()),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('course_info/being_filled/being_filled.html.twig', array(
            'pagination' => $pagination
        ));

    }

    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "ci.title|c.code|c.type|y.label|s.label"})
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param Request $request
     * @param $field
     * @return JsonResponse
     */
    public function autocomplete(CourseInfoDoctrineRepository $courseInfoDoctrineRepository, Request $request, $field): JsonResponse
    {
        $parameters = $request->query->all();
        $query = $parameters['query'];

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
    public function autocompleteS2(CourseInfoDoctrineRepository $courseInfoDoctrineRepository, Request $request): JsonResponse
    {
        $parameters = $request->query->all();
        $query = $parameters['q'];
        $field = $parameters['field_name'] ?? null;

        switch ($field) {
            default:
                $searchField = 'c.code';
                break;
        }

        $courseInfos = $courseInfoDoctrineRepository->findLikeQuery($query, $searchField);

        $data = array_map(function ($ci) use ($request) {
            $parameters = $request->query->all();
            $fromCodeYear = $parameters['fromCodeYear'] ?? null;
            if ($ci->getCodeYear(true) == $fromCodeYear) {
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
     * @return JsonResponse
     */
    public function autocompleteS3(CourseDoctrineRepository $courseDoctrineRepository): JsonResponse
    {
        $results = $courseDoctrineRepository->findAll();
        $courses = [];
        foreach($results as $course)
        {
            $courses[] = ['id' => $course->getId(), 'text' => $course->getCode()];
        }

        return $this->json($courses);
    }

}
