<?php

namespace LdapBundle\Factory;

use LdapBundle\Repository\TeacherRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Class TeacherRepositoryFactory
 * @package LdapBundle\Factory
 */
class TeacherRepositoryFactory
{
    /**
     * @var string
     */
    private $serviceName;

    /**
     * @var ContainerInterface
     */
    private $container;

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