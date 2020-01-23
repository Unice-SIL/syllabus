<?php


namespace AppBundle\Form\DataTransformer;


use AppBundle\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CourseWithHierarchyTransformer implements DataTransformerInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        /** @var Course $course */
        $course = $value;
        $parents = $course->getParents();

        $course = $this->em->getRepository(Course::class)->findOneBy(['etbId' => $course->getEtbId()]);

        if (null === $course) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $value->getEtbId()
            ));
        }

        foreach ($parents as $parent) {
            if ($parent === $course) {
                throw new TransformationFailedException('The course cannot be his own parent');
            }
            if (!$course->getParents()->contains($parent)) {
                $course->addParent($parent);
            }
        }

        return $course;
    }

}