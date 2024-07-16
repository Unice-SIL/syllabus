<?php


namespace App\Syllabus\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class ContainsAchievements
 * @package App\Syllabus\Validator\Constraints
 * @Annotation
 */
class ContainsAchievements extends Constraint
{
    public string $message = 'The string contains an illegal character: it can only contain letters or numbers.';
}
