<?php

namespace App\Ldap\Factory;

use App\Ldap\Repository\TeacherRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Class TeacherRepositoryFactory
 * @package App\Ldap\Factory
 */
class TeacherRepositoryFactory
{
    /**
     * @var string
     */
    private string $serviceName;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * TeacherRepositoryFactory constructor.
     * @param string $serviceName
     * @param ContainerInterface $container
     */
    public function __construct(string $serviceName, ContainerInterface $container)
    {
        $this->serviceName = $serviceName;
        $this->container = $container;
    }

    /**
     * @return TeacherRepositoryInterface
     */
    public function getService(): TeacherRepositoryInterface
    {
        try{
            return $this->container->get($this->serviceName);
        }catch (ServiceNotFoundException $e){
            throw $e;
        }
    }
}