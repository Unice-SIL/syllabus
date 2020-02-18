<?php


namespace AppBundle\Form\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class CourseFilterType extends AbstractType
{
    private  $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        switch ($options['context']) {
            case 'course':
                $dataAutocompletePath = 'app_admin.course_autocomplete';
                $fieldLabel = 'code';
                break;
            case 'course_info':
                $dataAutocompletePath = 'app_admin_course_info_autocomplete';
                $fieldLabel = 'c.code';
                break;
        }

        $builder
            ->add('code', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'app.form.course.label.code',
                'attr' => [
                    'class' => 'autocomplete-input',
                    'data-autocomplete-path' => $this->generator->generate($dataAutocompletePath, ['field' => $fieldLabel])
                ]
            ])
            ;

            if ($options['context'] === 'course') {
                $builder
                    ->add('title', TextFilterType::class, [
                        'condition_pattern' => FilterOperands::STRING_CONTAINS,
                        'label' => 'app.form.course.label.title',
                        'attr' => [
                            'class' => 'autocomplete-input',
                            'data-autocomplete-path' => $this->generator->generate($dataAutocompletePath, ['field' => 'title'])
                        ]
                    ])
                    ;
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'context' =>  'course_info',
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
            'method' => 'get',
        ]);
    }


    public function getParent()
    {
        return SharedableFilterType::class; // this allow us to use the "add_shared" option
    }

    public function getBlockPrefix()
    {
        return 'course_filter';
    }
}