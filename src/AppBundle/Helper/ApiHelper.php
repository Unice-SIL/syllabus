<?php


namespace AppBundle\Helper;


use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ApiHelper
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var Request
     */
    private $currentRequest;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * ApiHelper constructor.
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     * @param PaginatorInterface $paginator
     */
    public function __construct(
        RequestStack $requestStack,
        EntityManagerInterface $em,
        SerializerInterface $serializer,
        PaginatorInterface $paginator
    )
    {
        $this->requestStack = $requestStack;
        $this->currentRequest = $requestStack->getCurrentRequest();
        $this->em = $em;
        $this->serializer = $serializer;
        $this->paginator = $paginator;
    }

    public function getListApiResponse(string $className, array $options = []): array
    {

        $options = array_merge($defaultOptions = [
            'validFilterKeys' => []
        ], $options);

        $response = [
            'page' => $this->currentRequest->query->get('page'),
            'limit' => $this->currentRequest->query->get('limit'),
            'filters' => [],
            'data' => []
        ];

        foreach ($options['validFilterKeys'] as $validFilterKey) {
            $filter = $this->currentRequest->query->get($validFilterKey);
            if (null !== $filter) {
                $response['filters'][$validFilterKey] = $filter;
            }
        }

        if (null !== $response['page'] or null !== $response['limit']) {
            if ((!is_numeric($response['page']) or $response['page'] <= 0)) {
                $response['page'] = 1;
            }

            if ((!is_numeric($response['limit']) or $response['limit'] <= 0)) {
                $response['limit'] = 10;
            }
        }

        $years = $this->em->getRepository($className)->findBy($response['filters']);

        if ($response['page'] and $response['limit']) {
            $years = $this->paginator->paginate(
                $years,
                $response['page'],
                $response['limit']
            );
        }

        foreach ($years as $year) {
            $year = $this->serializer->toArray($year);
            $response['data'][] = $year;
        }

        return $response;
    }
}