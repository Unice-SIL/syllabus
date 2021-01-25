<?php

namespace App\Syllabus\Collection;

use App\Syllabus\Entity\CourseTeacher;

/**
 * Class CourseTeacherCollection
 * @package App\Syllabus\Collection
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