<?php


namespace AppBundle\Constant;

/**
 * Class UserRole
 * @package AppBundle\Constant
 */
class UserRole
{
    /*====================== USER ROLES ==================*/
    const ROLE_USER = 'ROLE_USER';

    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /*====================== ADMIN ROLES ==================*/
    const ROLE_ADMIN = 'ROLE_ADMIN';

    // YEARS
    const ROLE_ADMIN_YEAR = 'ROLE_ADMIN_YEAR';
    const ROLE_ADMIN_YEAR_LIST = 'ROLE_ADMIN_YEAR_LIST';
    const ROLE_ADMIN_YEAR_CREATE = 'ROLE_ADMIN_YEAR_CREATE';
    const ROLE_ADMIN_YEAR_UPDATE = 'ROLE_ADMIN_YEAR_UPDATE';

    // CRITICAL ACHIEVEMENTS
    const ROLE_ADMIN_CRITICAL_ACHIEVEMENT = 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT';
    const ROLE_ADMIN_CRITICAL_ACHIEVEMENT_LIST = 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_LIST';
    const ROLE_ADMIN_CRITICAL_ACHIEVEMENT_CREATE = 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_CREATE';
    const ROLE_ADMIN_CRITICAL_ACHIEVEMENT_UPDATE = 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_UPDATE';

    // ACTIVITIES
    const ROLE_ADMIN_ACTIVITY = 'ROLE_ADMIN_ACTIVITY';
    const ROLE_ADMIN_ACTIVITY_LIST = 'ROLE_ADMIN_ACTIVITY_LIST';
    const ROLE_ADMIN_ACTIVITY_CREATE = 'ROLE_ADMIN_ACTIVITY_CREATE';
    const ROLE_ADMIN_ACTIVITY_UPDATE = 'ROLE_ADMIN_ACTIVITY_UPDATE';

    // ACTIVITIES MODES
    const ROLE_ADMIN_ACTIVITYMODE = 'ROLE_ADMIN_ACTIVITYMODE';
    const ROLE_ADMIN_ACTIVITYMODE_LIST = 'ROLE_ADMIN_ACTIVITYMODE_LIST';
    const ROLE_ADMIN_ACTIVITYMODE_CREATE = 'ROLE_ADMIN_ACTIVITYMODE_CREATE';
    const ROLE_ADMIN_ACTIVITYMODE_UPDATE = 'ROLE_ADMIN_ACTIVITYMODE_UPDATE';

    // ACTIVITIES TYPES
    const ROLE_ADMIN_ACTIVITYTYPE = 'ROLE_ADMIN_ACTIVITYTYPE';
    const ROLE_ADMIN_ACTIVITYTYPE_LIST = 'ROLE_ADMIN_ACTIVITYTYPE_LIST';
    const ROLE_ADMIN_ACTIVITYTYPE_CREATE = 'ROLE_ADMIN_ACTIVITYTYPE_CREATE';
    const ROLE_ADMIN_ACTIVITYTYPE_UPDATE = 'ROLE_ADMIN_ACTIVITYTYPE_UPDATE';

    // CAMPUSES
    const ROLE_ADMIN_CAMPUS = 'ROLE_ADMIN_CAMPUS';
    const ROLE_ADMIN_CAMPUS_LIST = 'ROLE_ADMIN_CAMPUS_LIST';
    const ROLE_ADMIN_CAMPUS_CREATE = 'ROLE_ADMIN_CAMPUS_CREATE';
    const ROLE_ADMIN_CAMPUS_UPDATE = 'ROLE_ADMIN_CAMPUS_UPDATE';

    // DOMAINS
    const ROLE_ADMIN_DOMAIN = 'ROLE_ADMIN_DOMAIN';
    const ROLE_ADMIN_DOMAIN_LIST = 'ROLE_ADMIN_DOMAIN_LIST';
    const ROLE_ADMIN_DOMAIN_CREATE = 'ROLE_ADMIN_DOMAIN_CREATE';
    const ROLE_ADMIN_DOMAIN_UPDATE = 'ROLE_ADMIN_DOMAIN_UPDATE';

    // EQUIPMENTS
    const ROLE_ADMIN_EQUIPMENT = 'ROLE_ADMIN_EQUIPMENT';
    const ROLE_ADMIN_EQUIPMENT_LIST = 'ROLE_ADMIN_EQUIPMENT_LIST';
    const ROLE_ADMIN_EQUIPMENT_CREATE = 'ROLE_ADMIN_EQUIPMENT_CREATE';
    const ROLE_ADMIN_EQUIPMENT_UPDATE = 'ROLE_ADMIN_EQUIPMENT_UPDATE';

    // LANGUAGES
    const ROLE_ADMIN_LANGUAGE = 'ROLE_ADMIN_LANGUAGE';
    const ROLE_ADMIN_LANGUAGE_LIST = 'ROLE_ADMIN_LANGUAGE_LIST';
    const ROLE_ADMIN_LANGUAGE_CREATE = 'ROLE_ADMIN_LANGUAGE_CREATE';
    const ROLE_ADMIN_LANGUAGE_UPDATE = 'ROLE_ADMIN_LANGUAGE_UPDATE';

    // PERIODES
    const ROLE_ADMIN_PERIOD = 'ROLE_ADMIN_PERIOD';
    const ROLE_ADMIN_PERIOD_LIST = 'ROLE_ADMIN_PERIOD_LIST';
    const ROLE_ADMIN_PERIOD_CREATE = 'ROLE_ADMIN_PERIOD_CREATE';
    const ROLE_ADMIN_PERIOD_UPDATE = 'ROLE_ADMIN_PERIOD_UPDATE';

    // STRUCTURES
    const ROLE_ADMIN_STRUCTURE = 'ROLE_ADMIN_STRUCTURE';
    const ROLE_ADMIN_STRUCTURE_LIST = 'ROLE_ADMIN_STRUCTURE_LIST';
    const ROLE_ADMIN_STRUCTURE_CREATE = 'ROLE_ADMIN_STRUCTURE_CREATE';
    const ROLE_ADMIN_STRUCTURE_UPDATE = 'ROLE_ADMIN_STRUCTURE_UPDATE';

    // USERS
    const ROLE_ADMIN_USER = 'ROLE_ADMIN_USER';
    const ROLE_ADMIN_USER_LIST = 'ROLE_ADMIN_USER_LIST';
    const ROLE_ADMIN_USER_CREATE = 'ROLE_ADMIN_USER_CREATE';
    const ROLE_ADMIN_USER_UPDATE = 'ROLE_ADMIN_USER_UPDATE';


    /*====================== API ROLES ==================*/
    const ROLE_API = 'ROLE_API';

    const ROLE_API_COURSE = 'ROLE_API_COURSE_VIEW';
    const ROLE_API_COURSE_VIEW = 'ROLE_API_COURSE_VIEW';
    const ROLE_API_COURSE_LIST = 'ROLE_API_COURSE_LIST';
    const ROLE_API_COURSE_CREATE = 'ROLE_API_COURSE_CREATE';
    const ROLE_API_COURSE_UPDATE = 'ROLE_API_COURSE_UPDATE';

    const ROLE_API_GET_COURSE_INFO = 'ROLE_API_GET_COURSE_INFO';
    const ROLE_API_GET_COURSES_INFO = 'ROLE_API_GET_COURSES_INFO';
    const ROLE_API_POST_COURSE_INFO = 'ROLE_API_POST_COURSE_INFO';
    const ROLE_API_PUT_COURSE_INFO = 'ROLE_API_PUT_COURSE_INFO';

    const ROLE_API_GET_COURSE_PERMISSION = 'ROLE_API_GET_COURSE_PERMISSION';
    const ROLE_API_GET_COURSE_PERMISSIONS = 'ROLE_API_GET_COURSE_PERMISSIONS';
    const ROLE_API_POST_COURSE_PERMISSION = 'ROLE_API_POST_COURSE_PERMISSION';
    const ROLE_API_DELETE_COURSE_PERMISSION = 'ROLE_API_DELETE_COURSE_PERMISSION';

    const ROLE_API_GET_YEAR = 'ROLE_API_GET_YEAR';
    const ROLE_API_GET_YEARS = 'ROLE_API_GET_YEARS';
    const ROLE_API_POST_YEAR = 'ROLE_API_POST_YEAR';
    const ROLE_API_PUT_YEAR = 'ROLE_API_PUT_YEAR';

    const ROLE_API_GET_CAMPUS = 'ROLE_API_GET_CAMPUS';
    const ROLE_API_GET_CAMPUSES = 'ROLE_API_GET_CAMPUSES';

    const ROLE_API_GET_PERIOD = 'ROLE_API_GET_PERIOD';
    const ROLE_API_GET_PERIODS = 'ROLE_API_GET_PERIODS';

    const ROLE_API_GET_DOMAIN = 'ROLE_API_GET_DOMAIN';
    const ROLE_API_GET_DOMAINS = 'ROLE_API_GET_DOMAINS';

    const ROLE_API_GET_LANGUAGE = 'ROLE_API_GET_LANGUAGE';
    const ROLE_API_GET_LANGUAGES = 'ROLE_API_GET_LANGUAGES';

    const ROLE_API_ACTIVITY = 'ROLE_API_ACTIVITY';
    const ROLE_API_ACTIVITY_VIEW = 'ROLE_API_ACTIVITY_VIEW';
    const ROLE_API_ACTIVITY_LIST = 'ROLE_API_ACTIVITY_LIST';

    const ROLE_API_CRITICAL_ACHIEVEMENT = 'ROLE_API_CRITICAL_ACHIEVEMENT';
    const ROLE_API_CRITICAL_ACHIEVEMENT_VIEW = 'ROLE_API_CRITICAL_ACHIEVEMENT_VIEW';
    const ROLE_API_CRITICAL_ACHIEVEMENT_LIST = 'ROLE_API_CRITICAL_ACHIEVEMENT_LIST';

    const ROLE_API_LANGUAGE = 'ROLE_API_LANGUAGE';
    const ROLE_API_LANGUAGE_VIEW = 'ROLE_API_LANGUAGE_VIEW';
    const ROLE_API_LANGUAGE_LIST = 'ROLE_API_LANGUAGE_LIST';

    const ROLE_API_EQUIPMENT = 'ROLE_API_EQUIPMENT';
    const ROLE_API_EQUIPMENT_VIEW = 'ROLE_API_EQUIPMENT_VIEW';
    const ROLE_API_EQUIPMENT_LIST = 'ROLE_API_EQUIPMENT_LIST';

    const ROLE_API_DOMAIN = 'ROLE_API_DOMAIN';
    const ROLE_API_DOMAIN_VIEW = 'ROLE_API_DOMAIN_VIEW';
    const ROLE_API_DOMAIN_LIST = 'ROLE_API_DOMAIN_LIST';

    const ROLE_API_CAMPUS = 'ROLE_API_CAMPUS';
    const ROLE_API_CAMPUS_VIEW = 'ROLE_API_CAMPUS_VIEW';
    const ROLE_API_CAMPUS_LIST = 'ROLE_API_CAMPUS_LIST';

    const ROLE_API_ACTIVITY_MODE = 'ROLE_API_ACTIVITY_MODE';
    const ROLE_API_ACTIVITY_MODE_VIEW = 'ROLE_API_ACTIVITY_MODE_VIEW';
    const ROLE_API_ACTIVITY_MODE_LIST = 'ROLE_API_ACTIVITY_MODE_LIST';

    const ROLE_API_ACTIVITY_TYPE = 'ROLE_API_ACTIVITY_TYPE';
    const ROLE_API_ACTIVITY_TYPE_VIEW = 'ROLE_API_ACTIVITY_TYPE_VIEW';
    const ROLE_API_ACTIVITY_TYPE_LIST = 'ROLE_API_ACTIVITY_TYPE_LIST';

    const ROLE_API_PERIOD = 'ROLE_API_PERIOD';
    const ROLE_API_PERIOD_VIEW = 'ROLE_API_PERIOD_VIEW';
    const ROLE_API_PERIOD_LIST = 'ROLE_API_PERIOD_LIST';
    /*====================== End ROLE API ==================*/

    const ROLES = [
        self::ROLE_USER,
        self::ROLE_SUPER_ADMIN,
        self::ROLE_ADMIN,
        self::ROLE_ADMIN_YEAR,
        self::ROLE_ADMIN_YEAR_LIST,
        self::ROLE_ADMIN_YEAR_CREATE,
        self::ROLE_ADMIN_YEAR_UPDATE,
        self::ROLE_ADMIN_CRITICAL_ACHIEVEMENT,
        self::ROLE_ADMIN_CRITICAL_ACHIEVEMENT_LIST,
        self::ROLE_ADMIN_CRITICAL_ACHIEVEMENT_CREATE,
        self::ROLE_ADMIN_CRITICAL_ACHIEVEMENT_UPDATE,
        self::ROLE_ADMIN_ACTIVITY,
        self::ROLE_ADMIN_ACTIVITY_LIST,
        self::ROLE_ADMIN_ACTIVITY_CREATE,
        self::ROLE_ADMIN_ACTIVITY_UPDATE,
        self::ROLE_ADMIN_ACTIVITYMODE,
        self::ROLE_ADMIN_ACTIVITYMODE_LIST,
        self::ROLE_ADMIN_ACTIVITYMODE_CREATE,
        self::ROLE_ADMIN_ACTIVITYMODE_UPDATE,
        self::ROLE_ADMIN_ACTIVITYTYPE,
        self::ROLE_ADMIN_ACTIVITYTYPE_LIST,
        self::ROLE_ADMIN_ACTIVITYTYPE_CREATE,
        self::ROLE_ADMIN_ACTIVITYTYPE_UPDATE,
        self::ROLE_ADMIN_CAMPUS,
        self::ROLE_ADMIN_CAMPUS_LIST,
        self::ROLE_ADMIN_CAMPUS_CREATE,
        self::ROLE_ADMIN_CAMPUS_UPDATE,
        self::ROLE_ADMIN_DOMAIN,
        self::ROLE_ADMIN_DOMAIN_LIST,
        self::ROLE_ADMIN_DOMAIN_CREATE,
        self::ROLE_ADMIN_DOMAIN_UPDATE,
        self::ROLE_ADMIN_EQUIPMENT,
        self::ROLE_ADMIN_EQUIPMENT_LIST,
        self::ROLE_ADMIN_EQUIPMENT_CREATE,
        self::ROLE_ADMIN_EQUIPMENT_UPDATE,
        self::ROLE_ADMIN_LANGUAGE,
        self::ROLE_ADMIN_LANGUAGE_LIST,
        self::ROLE_ADMIN_LANGUAGE_CREATE,
        self::ROLE_ADMIN_LANGUAGE_UPDATE,
        self::ROLE_ADMIN_PERIOD,
        self::ROLE_ADMIN_PERIOD_LIST,
        self::ROLE_ADMIN_PERIOD_CREATE,
        self::ROLE_ADMIN_PERIOD_UPDATE,
        self::ROLE_ADMIN_STRUCTURE,
        self::ROLE_ADMIN_STRUCTURE_LIST,
        self::ROLE_ADMIN_STRUCTURE_CREATE,
        self::ROLE_ADMIN_STRUCTURE_UPDATE,
        self::ROLE_ADMIN_USER,
        self::ROLE_ADMIN_USER_LIST,
        self::ROLE_ADMIN_USER_CREATE,
        self::ROLE_ADMIN_USER_UPDATE,
        self::ROLE_API,
        self::ROLE_API_COURSE,
        self::ROLE_API_COURSE_VIEW,
        self::ROLE_API_COURSE_LIST,
        self::ROLE_API_COURSE_CREATE,
        self::ROLE_API_COURSE_UPDATE,
        self::ROLE_API_ACTIVITY,
        self::ROLE_API_ACTIVITY_VIEW,
        self::ROLE_API_ACTIVITY_LIST,
        self::ROLE_API_CRITICAL_ACHIEVEMENT,
        self::ROLE_API_CRITICAL_ACHIEVEMENT_VIEW,
        self::ROLE_API_CRITICAL_ACHIEVEMENT_LIST,
        self::ROLE_API_LANGUAGE,
        self::ROLE_API_LANGUAGE_VIEW,
        self::ROLE_API_LANGUAGE_LIST,
        self::ROLE_API_EQUIPMENT,
        self::ROLE_API_EQUIPMENT_VIEW,
        self::ROLE_API_EQUIPMENT_LIST,
        self::ROLE_API_DOMAIN,
        self::ROLE_API_DOMAIN_VIEW,
        self::ROLE_API_DOMAIN_LIST,
        self::ROLE_API_CAMPUS,
        self::ROLE_API_CAMPUS_VIEW,
        self::ROLE_API_CAMPUS_LIST,
        self::ROLE_API_ACTIVITY_MODE,
        self::ROLE_API_ACTIVITY_MODE_VIEW,
        self::ROLE_API_ACTIVITY_MODE_LIST,
        self::ROLE_API_ACTIVITY_TYPE,
        self::ROLE_API_ACTIVITY_TYPE_VIEW,
        self::ROLE_API_ACTIVITY_TYPE_LIST,
        self::ROLE_API_PERIOD,
        self::ROLE_API_PERIOD_VIEW,
        self::ROLE_API_PERIOD_LIST,
        //Todo: update below
        self::ROLE_API_GET_COURSE_INFO,
        self::ROLE_API_GET_COURSES_INFO,
        self::ROLE_API_POST_COURSE_INFO,
        self::ROLE_API_PUT_COURSE_INFO,
        self::ROLE_API_GET_COURSE_PERMISSION,
        self::ROLE_API_GET_COURSE_PERMISSIONS,
        self::ROLE_API_POST_COURSE_PERMISSION,
        self::ROLE_API_POST_COURSE_PERMISSION,
        self::ROLE_API_DELETE_COURSE_PERMISSION,
        self::ROLE_API_GET_YEAR,
        self::ROLE_API_GET_YEARS,
        self::ROLE_API_POST_YEAR,
        self::ROLE_API_PUT_YEAR,
        self::ROLE_API_GET_CAMPUS,
        self::ROLE_API_GET_CAMPUSES,
        self::ROLE_API_GET_PERIOD,
        self::ROLE_API_GET_PERIODS,
        self::ROLE_API_GET_DOMAIN,
        self::ROLE_API_GET_DOMAINS,
        self::ROLE_API_GET_LANGUAGE,
        self::ROLE_API_GET_LANGUAGES,
    ];

    const HIERARCHY = [
        self::ROLE_ADMIN => [
            self::ROLE_ADMIN_YEAR => [
                self::ROLE_ADMIN_YEAR_LIST,
                self::ROLE_ADMIN_YEAR_CREATE,
                self::ROLE_ADMIN_YEAR_UPDATE
            ],self::ROLE_ADMIN_CRITICAL_ACHIEVEMENT => [
                self::ROLE_ADMIN_CRITICAL_ACHIEVEMENT_LIST,
                self::ROLE_ADMIN_CRITICAL_ACHIEVEMENT_CREATE,
                self::ROLE_ADMIN_CRITICAL_ACHIEVEMENT_UPDATE
            ],
            self::ROLE_ADMIN_ACTIVITY => [
                self::ROLE_ADMIN_ACTIVITY_LIST,
                self::ROLE_ADMIN_ACTIVITY_CREATE,
                self::ROLE_ADMIN_ACTIVITY_UPDATE
            ],
            self::ROLE_ADMIN_ACTIVITYMODE => [
                self::ROLE_ADMIN_ACTIVITYMODE_LIST,
                self::ROLE_ADMIN_ACTIVITYMODE_CREATE,
                self::ROLE_ADMIN_ACTIVITYMODE_UPDATE
            ],
            self::ROLE_ADMIN_ACTIVITYTYPE => [
                self::ROLE_ADMIN_ACTIVITYTYPE_LIST,
                self::ROLE_ADMIN_ACTIVITYTYPE_CREATE,
                self::ROLE_ADMIN_ACTIVITYTYPE_UPDATE
            ],
            self::ROLE_ADMIN_CAMPUS => [
                self::ROLE_ADMIN_CAMPUS_LIST,
                self::ROLE_ADMIN_CAMPUS_CREATE,
                self::ROLE_ADMIN_CAMPUS_UPDATE
            ],
            self::ROLE_ADMIN_DOMAIN => [
                self::ROLE_ADMIN_DOMAIN_LIST,
                self::ROLE_ADMIN_DOMAIN_CREATE,
                self::ROLE_ADMIN_DOMAIN_UPDATE
            ],
            self::ROLE_ADMIN_EQUIPMENT => [
                self::ROLE_ADMIN_EQUIPMENT_LIST,
                self::ROLE_ADMIN_EQUIPMENT_CREATE,
                self::ROLE_ADMIN_EQUIPMENT_UPDATE
            ],
            self::ROLE_ADMIN_LANGUAGE => [
                self::ROLE_ADMIN_LANGUAGE_LIST,
                self::ROLE_ADMIN_LANGUAGE_CREATE,
                self::ROLE_ADMIN_LANGUAGE_UPDATE
            ],
            self::ROLE_ADMIN_PERIOD => [
                self::ROLE_ADMIN_PERIOD_LIST,
                self::ROLE_ADMIN_PERIOD_CREATE,
                self::ROLE_ADMIN_PERIOD_UPDATE
            ],
            self::ROLE_ADMIN_STRUCTURE => [
                self::ROLE_ADMIN_STRUCTURE_LIST,
                self::ROLE_ADMIN_STRUCTURE_CREATE,
                self::ROLE_ADMIN_STRUCTURE_UPDATE
            ],
            self::ROLE_ADMIN_USER => [
                self::ROLE_ADMIN_USER_LIST,
                self::ROLE_ADMIN_USER_CREATE,
                self::ROLE_ADMIN_USER_UPDATE
            ]
        ],
        self::ROLE_SUPER_ADMIN,
        self::ROLE_API => [
            self::ROLE_API_COURSE => [
                self::ROLE_API_COURSE_VIEW,
                self::ROLE_API_COURSE_LIST,
                self::ROLE_API_COURSE_CREATE,
                self::ROLE_API_COURSE_UPDATE,
            ],
            self::ROLE_API_ACTIVITY => [
                self::ROLE_API_ACTIVITY_VIEW,
                self::ROLE_API_ACTIVITY_LIST,
            ],
            self::ROLE_API_CRITICAL_ACHIEVEMENT => [
                self::ROLE_API_CRITICAL_ACHIEVEMENT_VIEW,
                self::ROLE_API_CRITICAL_ACHIEVEMENT_LIST,
            ],
            self::ROLE_API_LANGUAGE => [
                self::ROLE_API_LANGUAGE_VIEW,
                self::ROLE_API_LANGUAGE_LIST,
            ],
            self::ROLE_API_EQUIPMENT => [
                self::ROLE_API_EQUIPMENT_VIEW,
                self::ROLE_API_EQUIPMENT_LIST,
            ],
            self::ROLE_API_DOMAIN => [
                self::ROLE_API_DOMAIN_VIEW,
                self::ROLE_API_DOMAIN_LIST,
            ],
            self::ROLE_API_CAMPUS => [
                self::ROLE_API_CAMPUS_VIEW,
                self::ROLE_API_CAMPUS_LIST,
            ],
            self::ROLE_API_ACTIVITY_MODE => [
                self::ROLE_API_ACTIVITY_MODE_VIEW,
                self::ROLE_API_ACTIVITY_MODE_LIST,
            ],
            self::ROLE_API_ACTIVITY_TYPE => [
                self::ROLE_API_ACTIVITY_TYPE_VIEW,
                self::ROLE_API_ACTIVITY_TYPE_LIST,
            ],
            self::ROLE_API_PERIOD => [
                self::ROLE_API_PERIOD_VIEW,
                self::ROLE_API_PERIOD_LIST,
            ],
        ],
    ];
}