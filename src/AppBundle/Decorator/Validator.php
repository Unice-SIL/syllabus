<?php


namespace AppBundle\Decorator;


use AppBundle\Entity\CourseInfo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\TraceableValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator extends TraceableValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ValidatorInterface $validator, EntityManagerInterface $em)
    {
        parent::__construct($validator);
        $this->em = $em;
    }

    public function validateOnPut($value, $constraints = null, $groups = null)
    {
        if ($value instanceof CourseInfo) {

            $constraints = ($this->getMetadataFor(get_class($value))->getConstraints());

            if ($this->em->getRepository(CourseInfo::class)->findBy(['id' => $value->getId(), 'year' => $value->getYear(), 'course' => $value->getCourse()])) {
                $constraints = array_filter($constraints, function ($constraint) {
                    return !in_array('ignoreForPutApi', $constraint->payload);
                });
            };
        }

        return parent::validate($value, $constraints);
    }
}