<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\Year;
use AppBundle\Exception\ResourceValidationException;
use AppBundle\Form\Api\YearType;
use AppBundle\Helper\ApiHelper;
use AppBundle\Manager\YearManager;
use AppBundle\Repository\Doctrine\YearDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class YearApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/year", name="api.year.")
 * @IsGranted("ROLE_API_YEAR")
 */
class YearApiController extends Controller
{

    /**
     * @Route("", name="index", methods={"GET"})
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param YearDoctrineRepository $yearDoctrineRepository
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of year records",
     * )
     * @SWG\Parameter(
     *     name="label",
     *     in="query",
     *     type="string",
     *     description="A field used to filter years"
     * )
     * @SWG\Parameter(
     *     name="import",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter years"
     * )
     * @SWG\Parameter(
     *     name="edit",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter years"
     * )
     * @SWG\Parameter(
     *     name="current",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter years"
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
     * @IsGranted("ROLE_API_YEAR_LIST")
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, YearDoctrineRepository $yearDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['label' => 'text', 'import' => 'boolean', 'edit' => 'boolean', 'current' => 'boolean']
        ]);

        $qb = $yearDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config, [
            'groups' => ['default', 'year']
        ]);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a year by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected year"
     * )
     * @IsGranted("ROLE_API_YEAR_VIEW")
     * @param Year $year
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function showAction(Year $year, SerializerInterface $serializer)
    {
        $year = $serializer->serialize($year, 'json');

        $response = new Response($year, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("", name="post", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param ApiHelper $apiHelper
     * @param YearManager $yearManager
     * @return Response
     * @throws ResourceValidationException
     * @SWG\Response(
     *     response=201,
     *     description="Save the year from the body request",
     *     @Model(type=Year::class)
     * )
     *
     * @IsGranted("ROLE_API_YEAR_CREATE")
     */
    public function postAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ApiHelper $apiHelper, YearManager $yearManager)
    {
        $year = $yearManager->new();
        $form = $this->createForm(YearType::class, $year, ['context' => 'POST']);

        $form->submit(json_decode($request->getContent(), true));

        $apiHelper->throwExceptionIfEntityInvalid($form);

        $yearManager->create($year);

        $em->refresh($year);
        $response = new Response($serializer->serialize($year, 'json', SerializationContext::create()->setGroups(['default', 'year'])), Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/{id}", name="put", methods={"PUT"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Year $year
     * @param ApiHelper $apiHelper
     * @param YearManager $yearManager
     * @return Response
     * @throws ResourceValidationException
     * @SWG\Response(
     *     response=200,
     *     description="Update the complete year from the body request",
     *     @Model(type=Year::class)
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected year"
     * )
     *
     * @IsGranted("ROLE_API_YEAR_UPDATE")
     */
    public function putAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, Year $year, ApiHelper $apiHelper, YearManager $yearManager)
    {
        $form = $this->createForm(YearType::class, $year);

        $form->submit(json_decode($request->getContent(), true));

        $apiHelper->throwExceptionIfEntityInvalid($form);

        $yearManager->update($year);

        $em->refresh($year);
        $response = new Response($serializer->serialize($year, 'json', SerializationContext::create()->setGroups(['default', 'year'])), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}