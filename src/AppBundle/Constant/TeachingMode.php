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

    const CHOICES = [
        'Présentiel' => self::IN_CLASS,
        'Hybride' => self::HYBRID,
        'A distance' => self::DIST
    ];
}