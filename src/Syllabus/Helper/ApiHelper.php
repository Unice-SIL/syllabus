<?php


namespace App\Syllabus\Helper;


use App\Syllabus\Exception\ResourceValidationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;


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
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * ApiHelper constructor.
     * @param SerializerInterface $serializer
     * @param PaginatorInterface $paginator
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     */
    public function __construct(
        SerializerInterface $serializer,
        PaginatorInterface $paginator,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    )
    {
        $this->serializer = $serializer;
        $this->paginator = $paginator;
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @param array $options
     * @return array
     */
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

    /**
     * @param QueryBuilder $qb
     * @param array $config
     * @param array $options
     * @return array
     */
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

        foreach ($results as $result) {
            $context = null;
            if (!empty($options['groups'])) {
                $context = SerializationContext::create()->setGroups($options['groups']);
            }
            $result = $this->serializer->toArray($result, $context);
            $config['data'][] = $result;
        }

        return $config;
    }

    /**
     * @param $type
     * @param $value
     * @return bool|null
     */
    private function formatValue($type, $value)
    {
        if ($type === 'boolean') {
            if (strtolower($value) == 'true') {
                return true;
            }

            if (strtolower($value) == 'false') {
                return false;
            }

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

    /**
     * @param FormInterface $form
     * @throws ResourceValidationException
     */
    public function throwExceptionIfEntityInvalid(FormInterface $form)
    {

        if(!$form->isValid())
        {
            $errors = [];
            foreach ($form->getErrors(true) as $error)
            {
                $type = $error->getOrigin();
                $errorMessage = '';

                while ($type->getParent()) {
                    //if it's not the lower level we prefix by a . (e.g: higherLevel.mediumLevel.lowerLevel
                    $errorMessage = $errorMessage ? '.'.$errorMessage : ''.$errorMessage;

                    $errorMessage = $type->getName() . $errorMessage;
                    $type = $type->getParent();
                }

                $errorMessage = $errorMessage . ': ' . $error->getMessage();
                $errors[] = $errorMessage;
            }

            throw new ResourceValidationException(implode('__glue__', $errors));
        }


    }

    /**
     * @param Request $request
     * @param string $id
     * @return mixed|string
     */
    public function adIdToRequestContent(Request $request, string $id)
    {
        $entity = json_decode($request->getContent());
        $entity->id = $id;
        $entity = json_encode($entity);

        return $entity;
    }

}