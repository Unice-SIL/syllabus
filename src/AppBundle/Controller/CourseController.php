<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Course;
use AppBundle\Repository\Doctrine\CourseDoctrineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseController
 * @package AppBundle\Controller
 *
 * @Route("/course", name="app_admin_course_")
 */
class CourseController extends Controller
{
    /**
     * @Route("/autocomplete/{field}", name="autocomplete", methods={"GET"}, requirements={"field" = "code"})
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
        $courses = $courseDoctrineRepository->findLikeQuery($query, 'c.code');

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

}