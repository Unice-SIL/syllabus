<?php


namespace App\Syllabus\Helper;


use App\Syllabus\Helper\Report\Report;
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

    public function hydrateLineReportIfInvalidEntity($value, Report $report, string $lineIdReport, $options = [])
    {
        $options = array_merge([
            'constraints' => null,
            'groups' => null,
        ], $options);

        $violations = $this->validator->validate($value, $options['constraints'], $options['groups']);
        if (count($violations) > 0) {

            foreach ($violations as $violation) {
                $error = $violation->getPropertyPath() . ' => ' . $violation->getMessage() . "\n";
                $line = $report->addCommentToLine($error, $lineIdReport);
            }

            return $line;
        }

        return null;
    }
}