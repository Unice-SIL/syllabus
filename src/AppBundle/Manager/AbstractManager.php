<?php


namespace AppBundle\Manager;

use AppBundle\Helper\ErrorManager;
use AppBundle\Helper\Report\ReportingHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class AbstractManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var ErrorManager
     */
    protected $errorManager;
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $propertyAccessor;

    /**
     * AbstractManager constructor.
     * @param EntityManagerInterface $em
     * @param ErrorManager $errorManager
     */
    public function __construct(EntityManagerInterface $em, ErrorManager $errorManager)
    {
        $this->em = $em;
        $this->errorManager = $errorManager;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param object $entityData
     * $options values:
     *      flush (bool)
     *      validation_groups (string)
     *      find_by_parameters (array)
     * @param array $fieldsToUpdate
     * @param array $options
     * @throws \Exception
     */
    public function updateIfExistsOrCreate(object $entityData, array $fieldsToUpdate = [], $options = [])
    {
        $options = array_merge([
            'flush' => false,
            'validations_groups_new' => ['new'],
            'validations_groups_edit' => ['edit'],
            'report' => ReportingHelper::createReport('Insertion en base de données'),
            'lineIdReport' => null,
        ], $options);


        if (!isset($options['find_by_parameters'])) {
            $options['find_by_parameters'] = ['id' => $entityData->getId()];
        }

        if (!is_array($options['find_by_parameters'])) {
            throw new \Exception('The option "find_by_parameters" should be an array');
        }

        $className = $this->getClass();
        $entity = $this->em->getRepository($className)->findOneBy($options['find_by_parameters']);

        if ($entity instanceof $className) {
            $options['validation_groups'] = $options['validations_groups_edit'];
            foreach ($fieldsToUpdate as $field) {
                $newValue = $this->propertyAccessor->getValue($entityData, $field);
                $this->propertyAccessor->setValue($entity, $field, $newValue);
            }
        } else {
            $options['validation_groups'] = $options['validations_groups_new'];
            $entity = $entityData;
        }

        if ($options['report'] and $options['lineIdReport']) {
            $line = $this->errorManager->hydrateLineReportIfInvalidEntity($entity, $options['report'], $options['lineIdReport'], ['groups' => $options['validation_groups']]);
            if (null !== $line) {
                return $options['report'];
            }
        } else {
            $this->errorManager->throwExceptionIfError($entity, null, ['groups' => $options['validation_groups']]);
        }

        $this->em->persist($entity);

        if (true === $options['flush']) {
            $this->em->flush();
        }

        return $options['report'];
    }

    abstract protected function getClass(): string;
}