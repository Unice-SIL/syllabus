<?php


namespace App\Syllabus\Form\CourseInfo\Equipment;


use App\Syllabus\Entity\CourseInfo;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Resourcetype extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('educationalResources', CKEditorType::class, [
                'label' => 'app.equipment.form.educational_resources',
                'required' => false,
            ])
            ->add('bibliographicResources', CKEditorType::class, [
                'label' => 'app.equipment.form.bibliographic_resources',
                'required' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseInfo::class,
        ]);
    }
}