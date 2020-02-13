<?php

namespace AppBundle\Controller\Api;

use AppBundle\Decorator\Validator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use AppBundle\Entity\Course;
use Nelmio\ApiDocBundle\Annotation\Model;
use AppBundle\Exception\ResourceValidationException;
use AppBundle\Form\Api\CourseType;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\CourseDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/course", name="app.course.")
 */
class CourseApiController extends Controller
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of course records"
     * )
     * @SWG\Parameter(
     *     name="etbId",
     *     in="query",
     *     type="string",
     *     description="A field used to filter course"
     * )
     * @SWG\Parameter(
     *     name="type",
     *     in="query",
     *     type="string",
     *     description="A field used to filter course"
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="The results page of the pagination expected"
     * )
     * @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     type="integer",
     *     description="The limit of results per page"
     * )
     *
     * @IsGranted("ROLE_API_GET_COURSES")
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, CourseDoctrineRepository $courseDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['etbId' => 'text', 'type' => 'text']
        ]);

        $qb = $courseDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a course by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected course"
     * )
     *
     * @IsGranted("ROLE_API_GET_COURSE")
     */
    public function showAction(Course $course, SerializerInterface $serializer)
    {
        $course = $serializer->serialize($course, 'json');

        $response = new Response($course, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("", name="post", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param ApiHelper $apiHelper
     * @return Response
     * @throws ResourceValidationException
     *
     * @SWG\Response(
     *     response=201,
     *     description="Save the course from the body request",
     *     @Model(type=Course::class)
     * )
     * @IsGranted("ROLE_API_POST_COURSE")
     */
    public function postAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ApiHelper $apiHelper)
    {
        $year = new Course();
        $form = $this->createForm(CourseType::class, $year, ['validation_groups' => 'new']);

        $form->submit(json_decode($request->getContent()));

        $apiHelper->throwExceptionIfEntityInvalid($form);

        $em->persist($year);
        $em->flush();

        $em->refresh($year);
        $response = new Response($serializer->serialize($year, 'json', SerializationContext::create()->setGroups('api')), Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/{id}", name="put", methods={"PUT"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Course $course
     * @param ApiHelper $apiHelper
     * @return JsonResponse
     * @throws ResourceValidationException
     *
     * @SWG\Response(
     *     response=200,
     *     description="Update the complete course from the body request",
     *     @Model(type=Course::class)
     * )
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected course"
     * )
     * @IsGranted("ROLE_API_PUT_COURSE")
     */
    public function putAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, Course $course, ApiHelper $apiHelper)
    {
        $form = $this->createForm(CourseType::class, $course);

        $form->submit(json_decode($request->getContent()));

        $apiHelper->throwExceptionIfEntityInvalid($form);

        $em->flush();

        $em->refresh($course);
        $response = new Response($serializer->serialize($course, 'json', SerializationContext::create()->setGroups('api')), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
}