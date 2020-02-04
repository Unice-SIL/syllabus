<?php


namespace AppBundle\Helper;


use Doctrine\ORM\QueryBuilder;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;


class ApiHelper
{
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
     * @param SerializerInterface $serializer
     * @param PaginatorInterface $paginator
     */
    public function __construct(
        SerializerInterface $serializer,
        PaginatorInterface $paginator
    )
    {
        $this->serializer = $serializer;
        $this->paginator = $paginator;
    }

    public function createConfigFromRequest(Request $request, array $options = []): array
    {

        $options = array_merge($defaultOptions = [
            'validFilterKeys' => [],
        ], $options);

        $config = [
            'page' => $request->query->get('page'),
            'limit' => $request->query->get('limit'),
            'filters' => [],
            'data' => []
        ];

        foreach ($options['validFilterKeys'] as $validFilterKey => $type) {

            if (null === $value = $request->query->get($validFilterKey)) {
                continue;
            }

            if (null === $value = $this->formatValue($type, $value)) {
                continue;
            }

            $config['filters'][$validFilterKey] = $value;
        }

        if (null !== $config['page'] or null !== $config['limit']) {
            if ((!is_numeric($config['page']) or $config['page'] <= 0)) {
                $config['page'] = 1;
            }

            if ((!is_numeric($config['limit']) or $config['limit'] <= 0)) {
                $config['limit'] = 10;
            }
        }

        return $config;

    }

    public function setDataAndGetResponse(QueryBuilder $qb, array $config, array $options = [])
    {
        $options = array_merge($defaultOptions = [
            'groups' => [],
        ], $options);

        if ($config['page'] and $config['limit']) {
            $results = $this->paginator->paginate(
                $qb,
                $config['page'],
                $config['limit']
            );
        }
        else {
            $results = $qb->getQuery()->getResult();
        }

        $context = null;
        if (!empty($options['groups'])) {
            $context = SerializationContext::create()->setGroups($options['groups']);
        }
        foreach ($results as $result) {
            $result = $this->serializer->toArray($result, $context);
            $config['data'][] = $result;
        }

        return $config;
    }

    private function formatValue($type, $value)
    {
        if ($type === 'boolean') {
            if (!is_numeric($value)) {
                return null;
            }
            if ($value != 0 and $value != 1) {
                return null;
            }

            switch ($value) {
                case 0:
                    return false;
                    break;
                case 1:
                    return true;
                    break;
            }
        }

        return $value;
    }

}