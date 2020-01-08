<?php


namespace AppBundle\Constant;


class UserRole
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    const ROLES = [
        self::ROLE_USER,
        self::ROLE_ADMIN,
    ];
}