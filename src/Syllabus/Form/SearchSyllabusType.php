<?php


namespace App\Syllabus\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

/**
 *
 */
class SearchSyllabusType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('search', TextType::class, [
            'label' => false,
            'required' => false,
            'constraints' => [
                new Length(null, 4)
            ]
        ]);
        /*
            ->add('courses', Select2EntityType::class, [
            'label' => false,
            'remote_route' => 'app.common.autocomplete.generic_s2_courses',
            'required' => false,
            'multiple' => false,
            'mapped' => false,
            'class' => Course::class,
            'primary_key' => 'id',
            'text_property' => 'title',
            'language' => $this->request->getLocale(),
            'minimum_input_length' => 4,
            'remote_params' => [
                'entityName' => 'Course',
                'property' => 'title',
                'property_optional' => 'code'
            ],
        ]);*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'label' => false
        ));
    }
}