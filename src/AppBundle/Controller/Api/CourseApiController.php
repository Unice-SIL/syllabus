<?php

namespace AppBundle\Controller\Api;

use AppBundle\Decorator\Validator;
use AppBundle\Entity\Course;
use AppBundle\Exception\ResourceValidationException;
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
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CourseApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/course", name="app.course.")
 */
class CourseApiController extends Controller
{
    /**
     * @Route("/", name="index", methods={"GET"})
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
     */
    public function postAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, ApiHelper $apiHelper)
    {
        $course = $serializer->deserialize($request->getContent(), Course::class, 'json');

        $apiHelper->throwExceptionIfEntityInvalid($course, $validator);

        $em->persist($course);
        $em->flush();

        $response = new Response($serializer->serialize($course, 'json'), Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/{id}", name="put", methods={"PUT"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param Course $c
     * @param ApiHelper $apiHelper
     * @return JsonResponse
     * @throws ResourceValidationException
     */
    public function putAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, Course $c, ApiHelper $apiHelper)
    {
        $course = $apiHelper->adIdToRequestContent($request, $c->getId());

        $course = $serializer->deserialize($course, Course::class, 'json');

        $apiHelper->throwExceptionIfEntityInvalid($course);

        $em->flush();

        $response = new Response($serializer->serialize($course, 'json'), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}