<?php


namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class AchievementConstraintValidator
 * @package AppBundle\Validator\Constraints
 * @Annotation
 */
class AchievementConstraintValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        //$values = $this->context->getRoot()->getData();
        dump($value);
        $this->context->buildViolation($constraint->message)
            ->setParameter('test', $value)
            ->addViolation();
    }
}