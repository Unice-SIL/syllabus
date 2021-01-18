<?php

namespace App\Syllabus\Constant;

/**
 * Class Permission
 * @package AppBundle\Constant
 */
final class Permission
{
    const READ = 'READ';
    const WRITE = 'WRITE';

    const PERMISSIONS = [
        self::READ,
        self::WRITE,
    ];

}