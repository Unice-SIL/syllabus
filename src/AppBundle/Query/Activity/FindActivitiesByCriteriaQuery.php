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
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var string
     */
    private $size;

    /**
     * @var string
     */
    private $evaluation;

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
     * @param string $type
     * @return FindActivitiesByCriteriaQuery
     */
    public function setType(string $type): FindActivitiesByCriteriaQuery
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $mode
     * @return FindActivitiesByCriteriaQuery
     */
    public function setMode(string $mode): FindActivitiesByCriteriaQuery
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @param string $size
     * @return FindActivitiesByCriteriaQuery
     */
    public function setSize(string $size): FindActivitiesByCriteriaQuery
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @param string $evaluation
     * @return FindActivitiesByCriteriaQuery
     */
    public function setEvaluation(string $evaluation): FindActivitiesByCriteriaQuery
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * @return \ArrayObject
     * @throws \Exception
     */
    public function execute(): \ArrayObject
    {
        try{
            $activities = $this->activityRepository->findByCriteria($this->type, $this->mode, $this->size, $this->evaluation);
            return $activities;
        }catch (\Exception $e){
            throw $e;
        }
    }
}