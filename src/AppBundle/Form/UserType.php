<?php

namespace AppBundle\Form;

use AppBundle\Constant\UserRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'disabled' => true,
                'label' => 'Identifiant'
            ])
            ->add('firstname', null, [
                'disabled' => true,
                'label' => 'Prénom'
            ])
            ->add('lastname', null, [
                'disabled' => true,
                'label' => 'Nom'
            ])
            ->add('email', null, [
                'disabled' => true,
                'label' => 'Email'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => array_combine(UserRole::$allRoles, UserRole::$allRoles),
                'multiple' => true
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
