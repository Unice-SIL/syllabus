<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\CourseInfo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Nelmio\ApiDocBundle\Annotation\Model;
use AppBundle\Exception\ResourceValidationException;
use AppBundle\Form\Api\CourseInfoType;
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
     * @Route("", name="index", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of syllabus records"
     * )
     * @SWG\Parameter(
     *     name="courseId",
     *     in="query",
     *     type="string",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="yearId",
     *     in="query",
     *     type="string",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="structureId",
     *     in="query",
     *     type="string",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="title",
     *     in="query",
     *     type="string",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="published",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter syllabus"
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
     * @IsGranted("ROLE_API_GET_COURSES_INFO")
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
     * @SWG\Response(
     *     response=200,
     *     description="Returns a course info by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected course info"
     * )
     * @IsGranted("ROLE_API_GET_COURSE_INFO")
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
     * @param ApiHelper $apiHelper
     * @return Response
     * @throws ResourceValidationException
     *
     * @SWG\Response(
     *     response=201,
     *     description="Save the course info from the body request",
     *     @Model(type=CourseInfo::class)
     * )
     * @IsGranted("ROLE_API_POST_COURSES_INFO")
     */
    public function postAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ApiHelper $apiHelper)
    {
        $coureInfo = new CourseInfo();
        $form = $this->createForm(CourseInfoType::class, $coureInfo, ['validation_groups' => 'new']);

        $form->submit(json_decode($request->getContent()));

        $apiHelper->throwExceptionIfEntityInvalid($form);

        $em->persist($coureInfo);
        $em->flush();

        $em->refresh($coureInfo);
        $response = new Response($serializer->serialize($coureInfo, 'json', SerializationContext::create()->setGroups('api')), Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/{id}", name="put", methods={"PUT"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param CourseInfo $courseInfo
     * @param ApiHelper $apiHelper
     * @return JsonResponse
     * @throws ResourceValidationException
     *
     * @SWG\Response(
     *     response=200,
     *     description="Update the complete course info from the body request",
     *     @Model(type=CourseInfo::class)
     * )
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected course info"
     * )
     * @IsGranted("ROLE_API_PUT_COURSES_INFO")
     */
    public function putAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, CourseInfo $courseInfo, ApiHelper $apiHelper)
    {
        $form = $this->createForm(CourseInfoType::class, $courseInfo);

        $form->submit(json_decode($request->getContent(), true));

        $apiHelper->throwExceptionIfEntityInvalid($form);

        $em->flush();

        $em->refresh($courseInfo);
        $response = new Response($serializer->serialize($courseInfo, 'json', SerializationContext::create()->setGroups('api')), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
}