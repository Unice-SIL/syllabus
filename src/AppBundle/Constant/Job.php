<?php


namespace AppBundle\Constant;


class Job
{
    const APOGEE_STRUCTURE_IMPORT_COMAND = 'app:import:apogee:structure';


    const COMMANDS = [
        self::APOGEE_STRUCTURE_IMPORT_COMAND
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