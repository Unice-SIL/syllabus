<?php


namespace AppBundle\Controller\Api;


use AppBundle\Entity\CoursePermission;
use Nelmio\ApiDocBundle\Annotation\Model;
use AppBundle\Exception\ResourceValidationException;
use AppBundle\Form\Api\CoursePermissionType;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\CoursePermissionDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;

/**
 * Class CoursePermissionApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/course-permission", name="app.permission.")
 */
class CoursePermissionApiController extends Controller
{

    /**
     * @Route("/", name="index", methods={"GET"})
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param CoursePermissionDoctrineRepository $coursePermissionDoctrineRepository
     * @return JsonResponse
    /**
     * @Route("/", name="index", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of course permissions records"
     * )
     * @SWG\Parameter(
     *     name="permission",
     *     in="query",
     *     type="string",
     *     description="A field used to filter course permissions"
     * )
     * @SWG\Parameter(
     *     name="userId",
     *     in="query",
     *     type="string",
     *     description="A field used to filter course permissions"
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
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, CoursePermissionDoctrineRepository $coursePermissionDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['permission' => 'text', 'userId' => 'text']
        ]);

        $qb = $coursePermissionDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param CoursePermission $coursePermission
     * @param SerializerInterface $serializer
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns a course permission by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected course permission"
     * )
     */
    public function showAction(CoursePermission $coursePermission, SerializerInterface $serializer)
    {
        $course = $serializer->serialize($coursePermission, 'json');

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
     *     description="Save the course permission from the body request",
     *     @Model(type=CoursePermission::class)
     * )
     */
    public function postAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ApiHelper $apiHelper)
    {
        $coursePermission = new CoursePermission();
        $form = $this->createForm(CoursePermissionType::class, $coursePermission, ['validation_groups' => 'new']);

        $form->submit(json_decode($request->getContent()));

        $apiHelper->throwExceptionIfEntityInvalid($form);

        $em->persist($coursePermission);
        $em->flush();

        $em->refresh($coursePermission);
        $response = new Response($serializer->serialize($coursePermission, 'json', SerializationContext::create()->setGroups('api')), Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/{id}", name="put", methods={"PUT"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param CoursePermission $coursePermission
     * @param ApiHelper $apiHelper
     * @return JsonResponse
     * @throws ResourceValidationException
     *
     * @SWG\Response(
     *     response=200,
     *     description="Update the complete course permission from the body request",
     *     @Model(type=CoursePermission::class)
     * )
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected course permission"
     * )
     */
    public function putAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, CoursePermission $coursePermission, ApiHelper $apiHelper)
    {
        $form = $this->createForm(CoursePermissionType::class, $coursePermission);

        $form->submit(json_decode($request->getContent()));

        $apiHelper->throwExceptionIfEntityInvalid($form);

        $em->flush();

        $em->refresh($coursePermission);
        $response = new Response($serializer->serialize($coursePermission, 'json', SerializationContext::create()->setGroups('api')), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
}