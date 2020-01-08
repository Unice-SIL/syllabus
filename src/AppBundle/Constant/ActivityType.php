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

    const TYPES = [
        self::ACTIVITY,
        self::EVALUATION
    ];
}