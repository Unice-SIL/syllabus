<?php


namespace App\Syllabus\Constant;


class Job
{
    const APOGEE_STRUCTURE_IMPORT_COMAND = 'app:import:apogee:structure';
    const APOGEE_COURSE_IMPORT_COMAND = 'app:import:apogee:course';
    const MOODLE_PERMISSION_IMPORT_COMMAND = 'app:import:moodle:permission';
    const TEST_IMPORT_COMMAND = 'app:import:test';


    const COMMANDS = [
        self::APOGEE_STRUCTURE_IMPORT_COMAND,
        self::APOGEE_COURSE_IMPORT_COMAND,
        self::MOODLE_PERMISSION_IMPORT_COMMAND,
        self::TEST_IMPORT_COMMAND,
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