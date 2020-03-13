<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\ActivityMode;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\ActivityModeDoctrineRepository;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ActivityModeApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/activity-mode", name="api.activity_mode.")
 */
class ActivityModeApiController extends Controller
{

    /**
     * @Route("", name="index", methods={"GET"})
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param ActivityModeDoctrineRepository $activityModeDoctrineRepository
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of activity mode records",
     * )
     * @SWG\Parameter(
     *     name="label",
     *     in="query",
     *     type="string",
     *     description="A field used to filter activity mode records"
     * )
     * @SWG\Parameter(
     *     name="obsolete",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter activity mode records"
     * )
     * @IsGranted("ROLE_API_ACTIVITY_MODE_LIST")
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, ActivityModeDoctrineRepository $activityModeDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['label' => 'text', 'obsolete' => 'boolean']
        ]);

        $qb = $activityModeDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config, [
            'groups' => ['default', 'activity_mode']
        ]);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a activity mode by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected activity mode"
     * )
     * @IsGranted("ROLE_API_ACTIVITY_MODE_VIEW")
     * @param ActivityMode $activityMode
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function showAction(ActivityMode $activityMode, SerializerInterface $serializer)
    {
        $activityMode = $serializer->serialize($activityMode, 'json', SerializationContext::create()->setGroups(['default', 'activity_mode']));

        $response = new Response($activityMode, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}