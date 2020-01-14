<?php

namespace AppBundle\Constant;

/**
 * Class ActivitySize
 * @package AppBundle\Constant
 */
final class ActivityGroup
{
    const COLLECTIVE = 'collective';
    const GROUPS = 'groups';
    const INDIVIDUAL = 'individual';
    const HEAD = 'head';
    const TOGETHER = 'together';

    const ACTIVITY_GROUPS = [
        self::INDIVIDUAL,
        self::COLLECTIVE,
        self::GROUPS,
        self::TOGETHER
        //self::HEAD,
    ];
}