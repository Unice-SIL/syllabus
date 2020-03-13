<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Activity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\ActivityDoctrineRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActivityApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/activity", name="app.api.activity.")
 */
class ActivityApiController extends Controller
{
    /**
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param ActivityDoctrineRepository $activityDoctrineRepository
     * @return JsonResponse
     *
     * @Route("", name="index", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of activity records"
     * )
     * @SWG\Parameter(
     *     name="label",
     *     in="query",
     *     type="string",
     *     description="A field used to filter activity"
     * )
     * @SWG\Parameter(
     *     name="obsolete",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter activity"
     * )
     * @IsGranted("ROLE_API_ACTIVITY_LIST")
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, ActivityDoctrineRepository $activityDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['label' => 'text', 'obsolete' => 'boolean']
        ]);

        $qb = $activityDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config, [
            'groups' => ['default', 'activity']
        ]);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a activity by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected activity"
     * )
     * @IsGranted("ROLE_API_ACTIVITY_VIEW")
     * @param Activity $activity
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function showAction(Activity $activity, SerializerInterface $serializer)
    {
        $activity = $serializer->serialize($activity, 'json', SerializationContext::create()->setGroups(['default', 'activity']));

        $response = new Response($activity, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}