<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\CourseInfo;
use AppBundle\Exception\ResourceValidationException;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
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
 * Class CourseInfoApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/course-info", name="app.course_info.")
 */
class CourseInfoApiController extends Controller
{
    /**
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @return JsonResponse
     *
     * @Route("/", name="index", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of syllabus records"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="text",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="etbId",
     *     in="query",
     *     type="text",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="yearId",
     *     in="query",
     *     type="text",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="structureId",
     *     in="query",
     *     type="text",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="title",
     *     in="query",
     *     type="text",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="published",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter syllabus"
     * )
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, CourseInfoDoctrineRepository $courseInfoDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['courseId' => 'text', 'yearId' => 'text', 'structureId' => 'text', 'title' => 'text', 'published' => 'boolean']
        ]);

        $qb = $courseInfoDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config, ['groups' => ['api']]);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function showAction(CourseInfo $courseInfo, SerializerInterface $serializer)
    {
        $courseInfo = $serializer->serialize($courseInfo, 'json', SerializationContext::create()->setGroups(['api']));

        $response = new Response($courseInfo, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("", name="post", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param ApiHelper $apiHelper
     * @return Response
     * @throws ResourceValidationException
     */
    public function postAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, ApiHelper $apiHelper)
    {
        $courseInfo = $serializer->deserialize($request->getContent(), CourseInfo::class, 'json');

        $apiHelper->throwExceptionIfEntityInvalid($courseInfo, $validator);

        $em->persist($courseInfo);
        $em->flush();

        $response = new Response($serializer->serialize($courseInfo, 'json', SerializationContext::create()->setGroups('api')), Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/{id}", name="put", methods={"PUT"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param CourseInfo $ci
     * @param ApiHelper $apiHelper
     * @return JsonResponse
     * @throws ResourceValidationException
     */
    public function putAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, CourseInfo $ci, ApiHelper $apiHelper)
    {
        $courseInfo = $apiHelper->adIdToRequestContent($request, $ci->getId());

        $courseInfo = $serializer->deserialize($courseInfo, CourseInfo::class, 'json');

        $apiHelper->throwExceptionIfEntityInvalid($courseInfo);

        $em->flush();

        $response = new Response($serializer->serialize($courseInfo, 'json', SerializationContext::create()->setGroups('api')), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}