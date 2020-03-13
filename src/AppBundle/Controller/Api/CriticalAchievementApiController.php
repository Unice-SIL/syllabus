<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\CriticalAchievement;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\CriticalAchievementDoctrineRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CriticalAchievementApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/critical-achievement", name="app.api.critical_achievement.")
 */
class CriticalAchievementApiController extends Controller
{
    /**
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param CriticalAchievementDoctrineRepository $criticalAchievementDoctrineRepository
     * @return JsonResponse
     *
     * @Route("", name="index", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of critical achievement records"
     * )
     * @SWG\Parameter(
     *     name="label",
     *     in="query",
     *     type="string",
     *     description="A field used to filter critical achievement"
     * )
     * @SWG\Parameter(
     *     name="obsolete",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter critical achievement"
     * )
     * @SWG\Parameter(
     *     name="courseId",
     *     in="query",
     *     type="string",
     *     description="A field used to filter critical achievement"
     * )
     * @IsGranted("ROLE_API_CRITICAL_ACHIEVEMENT_LIST")
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, CriticalAchievementDoctrineRepository $criticalAchievementDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['label' => 'text', 'obsolete' => 'boolean', 'courseId' => 'text']
        ]);

        $qb = $criticalAchievementDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config, [
            'groups' => ['default', 'critical_achievement']
        ]);

        return $this->json($response);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a criticalAchievement by id",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The id of the expected criticalAchievement"
     * )
     * @IsGranted("ROLE_API_CRITICAL_ACHIEVEMENT_VIEW")
     * @param CriticalAchievement $criticalAchievement
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function showAction(CriticalAchievement $criticalAchievement, SerializerInterface $serializer)
    {
        $criticalAchievement = $serializer->serialize(
            $criticalAchievement,
            'json', SerializationContext::create()->setGroups(['default', 'critical_achievement'])
        );

        $response = new Response($criticalAchievement, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}