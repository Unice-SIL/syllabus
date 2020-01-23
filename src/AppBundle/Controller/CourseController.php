<?php


namespace AppBundle\Controller;


use AppBundle\Repository\Doctrine\CourseDoctrineRepository;
use AppBundle\Repository\Doctrine\StructureDoctrineRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class CourseController
 * @package AppBundle\Controller
 *
 * @Route("/course", name="app_admin_course_")
 */
class CourseController extends Controller
{
    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "etbId"})
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
        $courses = $courseDoctrineRepository->findLikeQuery($query, 'c.etbId');

        $data = array_map(function ($c) use ($request) {

            if (strtolower($c->getEtbId()) == strtolower($request->query->get('etbId'))) {
                return false;
            }
            return ['id' => $c->getId(), 'text' => $c->getEtbId()];
        }, $courses);

        return $this->json($data);
    }

}