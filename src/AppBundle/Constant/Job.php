<?php


namespace AppBundle\Constant;


class Job
{
    const COMMAND_TEST = 'app:test';
    const COMMAND_TEST_2 = 'app:test-2';

    const COMMANDS = [
        self::COMMAND_TEST,
        self::COMMAND_TEST_2,
    ];

    const STATUS_INIT = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_FAILED = 2;
    const STATUS_SUCCESS = 3;

    const STATUSES = [
        self::STATUS_IN_PROGRESS,
        self::STATUS_FAILED,
        self::STATUS_SUCCESS,
        self::STATUS_INIT,
    ];
}