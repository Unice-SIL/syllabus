<?php

namespace AppBundle\Constant;

/**
 * Class ActivityMode
 * @package AppBundle\Constant
 */
final class ActivityMode
{
    const IN_AUTONOMY = 'autonomy';
    const IN_CLASS = 'class';
    const EVAL_CC = 'cc';
    const EVAL_CT = 'ct';

    public static $activityModes = [
      self::IN_AUTONOMY,
      self::IN_CLASS,
    ];

    public static $roleModes = [
        self::EVAL_CC,
        self::EVAL_CT,
    ];

    public static $evaluationModes = [
      self::EVAL_CC,
      self::EVAL_CT,
    ];
}