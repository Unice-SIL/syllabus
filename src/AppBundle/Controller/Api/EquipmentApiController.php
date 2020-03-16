<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\Equipment;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\EquipmentDoctrineRepository;
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
 * Class EquipmentApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/equipment", name="api.equipment.")
 * @IsGranted("ROLE_API_EQUIPMENT")
 */
class EquipmentApiController extends Controller
{

    /**
     * @Route("", name="index", methods={"GET"})
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param EquipmentDoctrineRepository $equipmentDoctrineRepository
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of equipment records",
     * )
     * @SWG\Parameter(
     *     name="label",
     *     in="query",
     *     type="string",
     *     description="A field used to filter equipments"
     * )
     * @SWG\Parameter(
     *     name="obsolete",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter equipments"
     * )
     * @IsGranted("ROLE_API_EQUIPMENT_LIST")
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, EquipmentDoctrineRepository $equipmentDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['label' => 'text', 'obsolete' => 'boolean']
        ]);

        $qb = $equipmentDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config, [
            'groups' => ['default', 'equipment']
        ]);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a equipment by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected equipment"
     * )
     * @IsGranted("ROLE_API_EQUIPMENT_VIEW")
     * @param Equipment $equipment
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function showAction(Equipment $equipment, SerializerInterface $serializer)
    {
        $equipment = $serializer->serialize($equipment, 'json', SerializationContext::create()->setGroups(['default', 'equipment']));

        $response = new Response($equipment, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}