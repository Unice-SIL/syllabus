<?php

namespace AppBundle\Query\Activity;

use AppBundle\Query\QueryInterface;
use AppBundle\Repository\ActivityRepositoryInterface;

/**
 * Class FindActivitiesByCriteriaQuery
 * @package AppBundle\Query\Course
 */
class FindActivitiesByCriteriaQuery implements QueryInterface
{
    /**
     * @var ActivityRepositoryInterface
     */
    private $activityRepository;

    /**
     * @var bool
     */
    private $evaluation = false;

    /**
     * @var bool
     */
    private $distant = false;

    /**
     * @var bool
     */
    private $teacher = false;

    /**
     * FindCourseInfoByIdQuery constructor.
     * @param ActivityRepositoryInterface $activityRepository
     */
    public function __construct(
        ActivityRepositoryInterface $activityRepository
    )
    {
        $this->activityRepository = $activityRepository;
    }

    /**
     * @param bool $evaluation
     * @return FindActivitiesByCriteriaQuery
     */
    public function setEvaluation(bool $evaluation): FindActivitiesByCriteriaQuery
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * @param bool $distant
     * @return FindActivitiesByCriteriaQuery
     */
    public function setDistant(bool $distant): FindActivitiesByCriteriaQuery
    {
        $this->distant = $distant;

        return $this;
    }

    /**
     * @param bool $teacher
     * @return FindActivitiesByCriteriaQuery
     */
    public function setTeacher(bool $teacher): FindActivitiesByCriteriaQuery
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * @return \ArrayObject
     * @throws \Exception
     */
    public function execute(): \ArrayObject
    {
        $activities = new \ArrayObject();
        try{
            $activities = $this->activityRepository->findByCriteria($this->evaluation, $this->distant, $this->teacher);
        }catch (\Exception $e){
            throw $e;
        }
        return $activities;
    }
}