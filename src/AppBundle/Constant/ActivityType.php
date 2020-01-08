<?php

namespace AppBundle\Constant;

/**
 * Class ActivityType
 * @package AppBundle\Constant
 */
final class ActivityType
{
    const ACTIVITY = 'activity';
    const EVALUATION = 'evaluation';

    public static $allTypes = [
        self::ACTIVITY,
        self::EVALUATION
    ];
}