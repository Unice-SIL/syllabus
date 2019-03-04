<?php

namespace AppBundle\Collection;

use AppBundle\Entity\CourseTeacher;

/**
 * Class CourseTeacherCollection
 * @package AppBundle\Collection
 */
class CourseTeacherCollection extends GenericCollection
{
    /**
     *
     */
    const TYPE = CourseTeacher::class;

    /**
     * PeopleCollection constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TYPE);
    }

}