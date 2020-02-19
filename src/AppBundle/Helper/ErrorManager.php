<?php


namespace AppBundle\Helper;


use Symfony\Component\Translation\Exception\InvalidResourceException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ErrorManager
{
    /**
     * @var ValidatorInterface
     */
    private $validator;


    /**
     * ErrorManager constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function throwExceptionIfError($value, $constraints = null, $groups = null)
    {
        $violations = $this->validator->validate($value, $constraints, $groups);

        if (count($violations) > 0) {

            $message = 'Cannot validate the data.' . "\n";

            foreach ($violations as $violation) {
                $error = $violation->getPropertyPath() . ' => ' . $violation->getMessage() . "\n";
                $message .= ' ' . $error;
            }

            throw new InvalidResourceException($message);
        }
    }
}