<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\Language;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\LanguageDoctrineRepository;
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
 * Class LanguageApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/language", name="api.language.")
 */
class LanguageApiController extends Controller
{

    /**
     * @Route("", name="index", methods={"GET"})
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param LanguageDoctrineRepository $languageDoctrineRepository
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of language records",
     * )
     * @SWG\Parameter(
     *     name="label",
     *     in="query",
     *     type="string",
     *     description="A field used to filter languages"
     * )
     * @SWG\Parameter(
     *     name="obsolete",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter languages"
     * )
     * @IsGranted("ROLE_API_GET_LANGUAGES")
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, LanguageDoctrineRepository $languageDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['label' => 'text', 'obsolete' => 'boolean']
        ]);

        $qb = $languageDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config, [
            'groups' => ['default', 'language']
        ]);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a language by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected language"
     * )
     * @IsGranted("ROLE_API_GET_LANGUAGE")
     * @param Language $language
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function showAction(Language $language, SerializerInterface $serializer)
    {
        $language = $serializer->serialize($language, 'json', SerializationContext::create()->setGroups(['default', 'language']));

        $response = new Response($language, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}