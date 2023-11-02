<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\AskAdvice;
use App\Syllabus\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class AbstractFixture extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordHasherInterface $encoder
     */
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Return an array that contains the data from all entities will be created
     * For each sub-array which contain entity data, the key will be the reference used to store the entity
     * To reference an other object, start the property name by "@"
     *
     * [
     *  'my_entity_1' => [
     *      'label' => 'Label 1,
     *      'description' => 'Description 1'
     *      '@user' => 'reference_to_user_1'
     *  ],
     *   'my_entity_2' => [
     *      'label' => 'Label 2,
     *      'description' => 'Description 2',
     *      '@user' => 'reference_to_user_1'
     *  ],
     * ]
     * @return array []
     */
    abstract protected function getDataEntities(): array;

    /**
     * @return string
     */
    abstract protected function getEntityClassName(): string;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getDataEntities() as $reference => $data)
        {
            $entity = $this->generateEntity($data);
            if ($entity instanceof User)
            {
                $entity->setPassword($this->encoder->hashPassword($entity, UserFixture::PASSWORD_TEST));
            }
            $this->addReference($reference, $entity);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    /**
     * @param array $data
     * @return mixed
     */
    protected function generateEntity(array $data)
    {
        $entityClassName = $this->getEntityClassName();
        $entity = new $entityClassName();
        $this->populateEntity($entity, $data);
        return $entity;
    }

    /**
     * @param $entity
     * @param array $data
     */
    protected function populateEntity($entity, array $data)
    {
        $propertyAccess = PropertyAccess::createPropertyAccessor();
        foreach ($data as $property => $value) {
            if (preg_match('/^@/', $property) === 1) {
                $property = ltrim($property, '@');
                $value = $this->getReference($value);
            }
            $propertyAccess->setValue($entity, $property, $value);
        }
    }

    /**
     * @param string $name
     * @return array|object
     */
    public function getReference($name, ?string $class = NULL)
    {
        if (is_array($name)) {
            $references = new ArrayCollection();
            foreach ($name as $reference) {
                $references->add(parent::getReference($reference));
            }
            return $references;
        }

        return  parent::getReference($name);
    }
}