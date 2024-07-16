<?php

namespace App\Syllabus\Form;

use App\Syllabus\Constant\UserRole;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $context = $options['context'];
        $disabled = !($context === 'new');
        $builder
            ->add('username', null, [
                'disabled' => $disabled,
                'label' => 'admin.user.form.username'
            ])
            ->add('firstname', null, [
                'disabled' => $disabled,
                'label' => 'admin.user.form.firstname'
            ])
            ->add('lastname', null, [
                'disabled' => $disabled,
                'label' => 'admin.user.form.lastname'
            ])
            ->add('email', null, [
                'disabled' => $disabled,
                'label' => 'admin.user.form.email'
            ])
            ->add('groups', null, [
                'label' => 'admin.user.form.roles',
                'multiple' => true,
                'expanded' => true
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Syllabus\Entity\User',
            'context' => 'edit',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'appbundle_user';
    }


}
