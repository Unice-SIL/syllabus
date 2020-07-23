<?php

namespace AppBundle\Form\CourseInfo;

use AppBundle\Entity\CourseInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class DuplicateCourseInfoType extends AbstractType
{

    private  $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', HiddenType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'required' => true
            ])
            ->add('to', Select2EntityType::class, [
                'label' => 'app.form.duplicate_course_info.label.to',
                'multiple' => false,
                'remote_route' => 'app.admin.course_info.autocompleteS2',
                'class' => CourseInfo::class,
                'text_property' => 'id',
                'page_limit' => 10,
                'minimum_input_length' => 4,
                'placeholder' => 'app.dashboard.modal.placeholder',
                'constraints' => [
                    new NotBlank()
                ],
                'required' => true
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            //Todo:  set some default parameters
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_duplicate_course_info';
    }


}
