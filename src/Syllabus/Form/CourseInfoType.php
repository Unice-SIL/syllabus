<?php


namespace App\Syllabus\Form;


use App\Syllabus\Entity\Year;
use App\Syllabus\Repository\Doctrine\YearDoctrineRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use const Doctrine\ORM\qb;

class CourseInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $courseInfo = $builder->getData();
        $builder
            ->add('year', EntityType::class, [
                'class' => Year::class,
                'query_builder' => function (YearDoctrineRepository $yearDoctrineRepository) use ($courseInfo) {

                    $qb = $yearDoctrineRepository->getAvailableYearsByCourseBuilder($courseInfo->getCourse());

                    if ($year = $courseInfo->getYear()) {
                        $qb->orWhere($qb->expr()->eq('y', ':year'))
                            ->setParameter('year', $year)
                        ;
                    }

                    return $qb;
                },
            ])
            ->add('title')
            ->add('structure')
            ;
    }
}