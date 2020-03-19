<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\Campus;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\CampusDoctrineRepository;
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
 * Class CampusApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/campus", name="api.campus.")
 * @IsGranted("ROLE_API_CAMPUS")
 */
class CampusApiController extends Controller
{

    /**
     * @Route("", name="index", methods={"GET"})
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param CampusDoctrineRepository $campusDoctrineRepository
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of campus records",
     * )
     * @SWG\Parameter(
     *     name="label",
     *     in="query",
     *     type="string",
     *     description="A field used to filter campuses"
     * )
     * @SWG\Parameter(
     *     name="obsolete",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter campuses"
     * )
     * @IsGranted("ROLE_API_CAMPUS_LIST")
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, CampusDoctrineRepository $campusDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['label' => 'text', 'obsolete' => 'boolean']
        ]);

        $qb = $campusDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config, [
            'groups' => ['default', 'campus']
        ]);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a campus by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected campus"
     * )
     * @IsGranted("ROLE_API_CAMPUS_VIEW")
     * @param Campus $campus
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function showAction(Campus $campus, SerializerInterface $serializer)
    {
        $campus = $serializer->serialize($campus, 'json', SerializationContext::create()->setGroups(['default', 'campus']));

        $response = new Response($campus, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}