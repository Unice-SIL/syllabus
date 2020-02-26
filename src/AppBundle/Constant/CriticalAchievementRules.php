<?php


namespace AppBundle\Constant;


class CriticalAchievementRules
{
    const SCORE = 'Score';
    const NO_RULE = 'Aucune';

    const RULES = [
        'Aucune' => self::NO_RULE,
        'Score' => self::SCORE,
    ];
}