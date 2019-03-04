<?php

namespace AppBundle\Factory;

use AppBundle\Query\CourseTeacher\Adapter\FindCourseTeacherByIdQueryInterface;
use AppBundle\Query\CourseTeacher\Adapter\SearchCourseTeacherQueryInterface;
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
     * @return SearchCourseTeacherQueryInterface
     * @throws \Exception
     */
    public function getSearchQuery(string $sourceId): SearchCourseTeacherQueryInterface
    {
        try{
            return $this->getService($sourceId, 'searchService');
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param string $sourceId
     * @return FindCourseTeacherByIdQueryInterface
     * @throws \Exception
     */
    public function getFindByIdQuery(string $sourceId): FindCourseTeacherByIdQueryInterface
    {
        try{
            return $this->getService($sourceId, 'findByIdService');
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param string $sourceId
     * @param string $serviceId
     * @return object
     * @throws \Exception
     */
    private function getService(string $sourceId, string $serviceId){
        if(!array_key_exists($sourceId, $this->sources)){
            throw new \Exception(sprintf('Source %s does not exist in course_teacher_factory.sources parameter', $sourceId));
        }
        $source = $this->sources[$sourceId];
        if(!array_key_exists($serviceId, $source)){
            throw new \Exception(sprintf('Service %s does not exist for source %s in course_teacher_factory.sources parameter', $serviceId, $sourceId));
        }
        $serviceId = $source[$serviceId];
        try {
            $service = $this->container->get($serviceId);
        }catch (ServiceNotFoundException $e){
            throw $e;
        }
        return $service;
    }
}