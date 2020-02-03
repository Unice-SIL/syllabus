<?php


namespace AppBundle\Controller\Api;


use AppBundle\Entity\Year;
use AppBundle\Helper\ApiHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;

/**
 * Class YearApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/year", name="api.year.")
 */
class YearApiController extends Controller
{

    /**
     * @Route("/", name="index", methods={"GET"})
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of year records",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="string",
     *     description="A field used to filter years"
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
     *     description="The result page of the pagination expected"
     * )
     * @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     type="integer",
     *     description="The limit of results per page"
     * )
     */
    public function listYearAction(ApiHelper $apiHelper)
    {

        $responseArray = $apiHelper->getListApiResponse(Year::class, [
            'validFilterKeys' => ['id', 'label', 'import', 'edit', 'current']
        ]);

        return $this->json($responseArray);
    }

}