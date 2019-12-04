<?php


namespace AppBundle\Doctrine;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Ramsey\Uuid\Uuid;

class IdGenerator extends AbstractIdGenerator
{

    /**
     * @param EntityManager $em
     * @param object|null $entity
     * @return mixed|string
     * @throws \Exception
     */
    public function generate(EntityManager $em, $entity)
    {
        $uuid = Uuid::uuid4();

        if (null !== $em->getRepository(get_class($entity))->findOneBy(['id' => $uuid])) {
            $uuid = $this->generate($em, $entity);
        }

        return $uuid;
    }
}