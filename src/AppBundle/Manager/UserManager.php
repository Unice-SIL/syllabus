<?php


namespace AppBundle\Manager;


use AppBundle\Entity\User;
use Ramsey\Uuid\Uuid;

class UserManager
{
    public function create()
    {
        $user = new User();
        $user->setId(Uuid::uuid4());
        return $user;
    }
}