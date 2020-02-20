<?php


namespace AppBundle\Repository;


use AppBundle\Entity\CourseCriticalAchievement;

interface CourseCriticalAchievementRepositoryInterface
{
    /**
     * @param string $id
     * @return CourseCriticalAchievement
     */
    public function find(string $id);

    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     */
    public function update(CourseCriticalAchievement $courseCriticalAchievement): void;

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     */
    public function create(CourseCriticalAchievement $courseCriticalAchievement): void;

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     */
    public function delete(CourseCriticalAchievement $courseCriticalAchievement): void;

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array;
}