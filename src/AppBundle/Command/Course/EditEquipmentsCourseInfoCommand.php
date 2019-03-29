<?php

namespace AppBundle\Command\Course;

use AppBundle\Command\CommandInterface;
use AppBundle\Entity\CourseInfo;

/**
 * Class EditEquimpentsCourseInfoCommand
 * @package AppBundle\Command\Course
 */
class EditEquipmentsCourseInfoCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $id;



    /**
     * EditClosingRemarksCourseInfoCommand constructor.
     * @param CourseInfo $courseInfo
     */
    public function __construct(CourseInfo $courseInfo)
    {

    }

    /**
     * @param CourseInfo $entity
     * @return CourseInfo
     */
    public function filledEntity($entity): CourseInfo
    {
    
        return $entity;
    }


    /**
     *
     */
    public function __clone()
    {
    }
}