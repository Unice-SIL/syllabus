<?php


namespace App\Syllabus\Manager;

use App\Syllabus\Helper\ErrorManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

abstract class AbstractManager
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;
    /**
     * @var ErrorManager
     */
    protected ErrorManager $errorManager;
    /**
     * @var PropertyAccessor
     */
    private PropertyAccessor $propertyAccessor;

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
     *      force_create (bool)
     *      flush (bool)
     *      validation_groups (string)
     *      find_by_parameters (array)
     * @param array $fieldsToUpdate
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public function updateIfExistsOrCreate(object $entityData, array $fieldsToUpdate = [], array $options = []): mixed
    {
        $options = array_merge([
            'force_create' => false,
            'flush' => false,
            'validations_groups_new' => ['new'],
            'validations_groups_edit' => ['edit'],
            'report' => null,
            'lineIdReport' => null,
        ], $options);

        if (!isset($options['find_by_parameters'])) {
            $options['find_by_parameters'] = ['id' => $entityData->getId()];
        }

        if (!is_array($options['find_by_parameters'])) {
            throw new \Exception('The option "find_by_parameters" should be an array');
        }

        $className = $this->getClass();
        $entity = null;
        if(!$options['force_create'])
        {
            $entity = $this->em->getRepository($className)->findOneBy($options['find_by_parameters']);
        }

        if ($entity instanceof $className) {
            $options['validation_groups'] = $options['validations_groups_edit'];
            foreach ($fieldsToUpdate as $field) {
                $newValue = $this->propertyAccessor->getValue($entityData, $field);
                $this->propertyAccessor->setValue($entity, $field, $newValue);
            }
        } else {
            $options['validation_groups'] = $options['validations_groups_new'];
            $entity = $entityData;
            $this->em->persist($entity);
        }

        if ($options['report'] and $options['lineIdReport']) {
            $line = $this->errorManager->hydrateLineReportIfInvalidEntity($entity, $options['report'], $options['lineIdReport'], ['groups' => $options['validation_groups']]);
            if (null !== $line) {
                return $entity;
            }
        } else {
            $this->errorManager->throwExceptionIfError($entity, null, $options['validation_groups']);
        }

        if (true === $options['flush']) {
            $this->em->flush();
        }

        return $entity;
    }

    abstract protected function getClass(): string;
}