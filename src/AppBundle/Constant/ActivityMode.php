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

    const ACTIVITY_MODES = [
      self::IN_AUTONOMY,
      self::IN_CLASS,
    ];

    const EVALUATION_MODES = [
      self::EVAL_CC,
      self::EVAL_CT,
    ];
}