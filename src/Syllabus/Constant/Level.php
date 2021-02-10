<?php

namespace App\Syllabus\Constant;

/**
 * Class Level
 * @package App\Syllabus\Constant
 */
final class Level
{
    const BEGINNER = 'beginner';

    const INTERMEDIATE = 'intermediate';

    const ADVANCED = 'advanced';

    const CHOICES = [
        'Débutant' => self::BEGINNER,
        'Intermédiaire' => self::INTERMEDIATE,
        'Avancé' => self::ADVANCED
    ];
}