<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Course;
use AppBundle\Entity\CriticalAchievement;

interface CriticalAchievementRepositoryInterface
{
    /**
     * @param string $id
     * @return object
     * @throws \Exception
     */
    public function find(string $id): CriticalAchievement;

    /**
     * @return \ArrayObject|mixed
     * @throws \Exception
     */
    public function findAll();

    /**
     * @param CriticalAchievement $criticalAchievement
     * @throws \Exception
     */
    public function update(CriticalAchievement $criticalAchievement): void;

    /**
     * @param CriticalAchievement $criticalAchievement
     * @throws \Exception
     */
    public function create(CriticalAchievement $criticalAchievement): void;

    /**
     * @param CriticalAchievement $criticalAchievement
     */
    public function delete(CriticalAchievement $criticalAchievement): void;

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array;

    /**
     * @param string $query
     * @param Course $course
     * @return array
     */
    public function findLikeQueryByCourse(string $query, Course $course): array;
}