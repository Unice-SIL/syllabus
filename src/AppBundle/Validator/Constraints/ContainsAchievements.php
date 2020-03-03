<?php


namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class ContainsAchievements
 * @package AppBundle\Validator\Constraints
 * @Annotation
 */
class ContainsAchievements extends Constraint
{
    public $message = 'The string contains an illegal character: it can only contain letters or numbers.';
}
