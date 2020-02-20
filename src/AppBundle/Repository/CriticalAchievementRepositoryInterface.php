<?php


namespace AppBundle\Repository;


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
}