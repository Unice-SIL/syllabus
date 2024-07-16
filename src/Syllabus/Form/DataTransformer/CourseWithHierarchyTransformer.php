<?php


namespace App\Syllabus\Form\DataTransformer;


use App\Syllabus\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CourseWithHierarchyTransformer implements DataTransformerInterface
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

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

        $course = $this->em->getRepository(Course::class)->findOneBy(['code' => $course->getCode()]);

        if (null === $course) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $value->getCode()
            ));
        }

        foreach ($parents as $parent) {
            if (!$course->getParents()->contains($parent)) {
                $course->addParent($parent);
            }
        }

        return $course;
    }

}