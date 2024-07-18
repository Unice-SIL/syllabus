<?php


namespace App\Syllabus\Form\CourseInfo\dashboard;


use App\Syllabus\Entity\CourseInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class PublishCourseInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var CourseInfo $courseInfo */
        $courseInfo = $builder->getData();

        if (!$courseInfo instanceof CourseInfo) {
            throw new \Exception('You have to pass a CourseInfo instance as data');
        }

        $builder->add('publish', HiddenType::class, [
            'mapped' => false,
            'attr'=>array('style'=>'display:none')
        ]);
    }
}