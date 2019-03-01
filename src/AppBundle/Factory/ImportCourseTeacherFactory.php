<?php

namespace AppBundle\Factory;

use AppBundle\Query\CourseTeacher\Adapter\ImportCourseTeacherQueryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Class ImportCourseTeacherFactory
 * @package AppBundle\Factory
 */
class ImportCourseTeacherFactory
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $sources = [];

    /**
     * ImportCourseTeacherFactory constructor.
     * @param array $courseTeacherFactoryParams
     * @param ContainerInterface $container
     * @throws \Exception
     */
    public function __construct(array $courseTeacherFactoryParams, ContainerInterface $container)
    {
        $this->container = $container;
        if(!is_array($courseTeacherFactoryParams)){
            throw new \Exception('Parameter course_teacher_factory must be an array');
        }
        if(!array_key_exists('sources', $courseTeacherFactoryParams)){
            throw new \Exception('Parameter course_teacher_factory.sources not found');
        }
        $this->sources = $courseTeacherFactoryParams['sources'];
        if(!is_array($this->sources)){
            throw new \Exception('Parameter course_teacher_factory.sources must be an array');
        }
    }

    /**
     * @param string $sourceId
     * @return ImportCourseTeacherQueryInterface
     * @throws \Exception
     */
    public function getQuery(string $sourceId): ImportCourseTeacherQueryInterface
    {
        if(!array_key_exists($sourceId, $this->sources)){
            throw new \Exception(sprintf('Source %s does not exist in course_teacher_factory.sources parameter', $sourceId));
        }
        $source = $this->sources[$sourceId];
        $serviceId = null;
        if(array_key_exists('service', $source)){
            $serviceId = $source['service'];
        }else{
            $serviceId = $sourceId;
        }
        try {
            $service = $this->container->get($serviceId);
        }catch (ServiceNotFoundException $e){
            throw $e;
        }
        return $service;
    }
}