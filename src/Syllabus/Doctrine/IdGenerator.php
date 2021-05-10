<?php


namespace App\Syllabus\Doctrine;


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
        return Uuid::uuid4();
    }
}