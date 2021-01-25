<?php

namespace App\Syllabus\Constant;

/**
 * Class ActivityType
 * @package App\Syllabus\Constant
 */
final class ActivityType
{
    const ACTIVITY = 'activity';
    const EVALUATION = 'evaluation';

    const TYPES = [
        self::ACTIVITY,
        self::EVALUATION
    ];
}