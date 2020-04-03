<?php


namespace AppBundle\Form\CourseInfo\dashboard;


use AppBundle\Entity\CourseInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PublishCourseInfoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var CourseInfo $courseInfo */
        $courseInfo = $builder->getData();

        if (!$courseInfo instanceof CourseInfo) {
            throw new \Exception('You have to pass a CourseInfo instance as data');
        }

        $builder->add('publish', CheckboxType::class, [
            'mapped' => false,
            'label' => false,
            'required' => false,
            'attr' => [
                'data-toggle' => 'toggle',
                'data-onstyle' => 'primary',
                'data-on' => 'Oui',
                'data-off' => 'Non',
                'checked' => $courseInfo->getPublicationDate() === null ? false : true,
            ]
        ]);
    }
}