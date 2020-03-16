<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\Domain;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\DomainDoctrineRepository;
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
 * Class DomainApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/domain", name="api.domain.")
 * @IsGranted("ROLE_API_DOMAIN")
 */
class DomainApiController extends Controller
{

    /**
     * @Route("", name="index", methods={"GET"})
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param DomainDoctrineRepository $domainDoctrineRepository
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of domain records",
     * )
     * @SWG\Parameter(
     *     name="label",
     *     in="query",
     *     type="string",
     *     description="A field used to filter domains"
     * )
     * @SWG\Parameter(
     *     name="obsolete",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter domains"
     * )
     * @IsGranted("ROLE_API_DOMAIN_LIST")
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, DomainDoctrineRepository $domainDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['label' => 'text', 'obsolete' => 'boolean']
        ]);

        $qb = $domainDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config, [
            'groups' => ['default', 'domain']
        ]);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a domain by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected domain"
     * )
     * @IsGranted("ROLE_API_DOMAIN_VIEW")
     * @param Domain $domain
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function showAction(Domain $domain, SerializerInterface $serializer)
    {
        $domain = $serializer->serialize($domain, 'json', SerializationContext::create()->setGroups(['default', 'domain']));

        $response = new Response($domain, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}