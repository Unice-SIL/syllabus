<?php


namespace App\Syllabus\Doctrine;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Exception;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

class IdGenerator extends AbstractIdGenerator
{

    /**
     * @param EntityManager $em
     * @param object|null $entity
     * @return UuidV4
     * @throws Exception
     */
    public function generate(EntityManager $em, $entity): UuidV4
    {
        return Uuid::v4();
    }
}