<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CourseInfo;

/**
 * Interface CourseInfoRepositoryInterface
 * @package AppBundle\Repository
 */
interface CourseInfoRepositoryInterface
{
    /**
     * Find  course info by id
     * @param string $id
     * @return CourseInfo|null
     */
    public function find(string $id): ?CourseInfo;

}