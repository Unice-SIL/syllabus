<?php

namespace AppBundle\Constant;

/**
 * Class TeachingMode
 * @package AppBundle\Constant
 */
final class TeachingMode
{
    const IN_CLASS = 'class';

    const HYBRID = 'hybrid';

    const DIST = 'distant';

    const TEACHING_MODES = [
        self::IN_CLASS,
        self::HYBRID,
        self::DIST
    ];


    const CHOICES = [
        'Présentiel' => self::IN_CLASS,
        'Hybride' => self::HYBRID,
        'A distance' => self::DIST
    ];
}