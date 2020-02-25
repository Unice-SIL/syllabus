<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\Period;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\PeriodDoctrineRepository;
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
 * Class PeriodApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/period", name="api.period.")
 */
class PeriodApiController extends Controller
{

    /**
     * @Route("", name="index", methods={"GET"})
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param PeriodDoctrineRepository $periodDoctrineRepository
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of period records",
     * )
     * @SWG\Parameter(
     *     name="label",
     *     in="query",
     *     type="string",
     *     description="A field used to filter periods"
     * )
     * @SWG\Parameter(
     *     name="obsolete",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter periods"
     * )
     * @IsGranted("ROLE_API_GET_PERIODS")
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, PeriodDoctrineRepository $periodDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['label' => 'text', 'obsolete' => 'boolean']
        ]);

        $qb = $periodDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config, [
            'groups' => ['default', 'period']
        ]);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a period by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected period"
     * )
     * @IsGranted("ROLE_API_GET_PERIOD")
     * @param Period $period
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function showAction(Period $period, SerializerInterface $serializer)
    {
        $period = $serializer->serialize($period, 'json', SerializationContext::create()->setGroups(['default', 'period']));

        $response = new Response($period, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}