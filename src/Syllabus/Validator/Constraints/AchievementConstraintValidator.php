<?php


namespace App\Syllabus\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class AchievementConstraintValidator
 * @package App\Syllabus\Validator\Constraints
 * @Annotation
 */
class AchievementConstraintValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        //$values = $this->context->getRoot()->getData();
        $this->context->buildViolation($constraint->message)
            ->setParameter('test', $value)
            ->addViolation();
    }
}