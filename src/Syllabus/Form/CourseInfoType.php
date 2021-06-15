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
    /**
     * @var YearDoctrineRepository
     */
    private $yearDoctrineRepository;

    /**
     * CourseInfoType constructor.
     * @param YearDoctrineRepository $yearDoctrineRepository
     */
    public function __construct(YearDoctrineRepository $yearDoctrineRepository)
    {
        $this->yearDoctrineRepository = $yearDoctrineRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $courseInfo = $builder->getData();
        $courseInfos = $courseInfo->getCourse()->getCourseInfos();
        $years = array_filter($this->yearDoctrineRepository->findAll(), function(Year $year) use ($courseInfos){
            return !$courseInfos->exists(function($key, $ci) use ($year) {
                return $ci->getYear() === $year;
            });
        });

        $builder
            ->add('year', EntityType::class, [
                'class' => Year::class,
                'choices' => $years
            ])
            ->add('title')
            ->add('structure')
            ;
    }
}