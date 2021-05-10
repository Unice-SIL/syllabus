<?php


namespace App\Syllabus\Form\CourseInfo\CourseAchievement;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CourseAssistTutoringType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tutoringTeacher', CheckboxType::class, [
                'required' => false,
                'label' => "Avec tuteur enseignant"
            ])
            ->add('tutoringStudent', CheckboxType::class, [
                'required' => false,
                'label' => "Avec tuteur étudiant"
            ])
            ->add('tutoringDescription', TextType::class, [
                'label' => 'Infos pratiques (facultatif)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Renseigner ici les dates, lieux, noms des enseignants...'
                ]]);
    }
}