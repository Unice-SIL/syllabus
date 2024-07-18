<?php


namespace App\Syllabus\Form\CourseInfo\Teaching;


use App\Syllabus\Entity\Teaching;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeachingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.type'
                ]
            ])
            ->add('hourlyVolume', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.hours'
                ]
            ])
            ->add('mode', HiddenType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teaching::class
        ]);
    }
}