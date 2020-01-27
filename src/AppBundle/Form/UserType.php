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
        $context = $options['context'];
        $disabled = $context === 'new' ? false : true;
        $builder
            ->add('username', null, [
                'disabled' => $disabled,
                'label' => 'Identifiant'
            ])
            ->add('firstname', null, [
                'disabled' => $disabled,
                'label' => 'Prénom'
            ])
            ->add('lastname', null, [
                'disabled' => $disabled,
                'label' => 'Nom'
            ])
            ->add('email', null, [
                'disabled' => $disabled,
                'label' => 'Email'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => array_combine(UserRole::ROLES, UserRole::ROLES),
                'multiple' => true,
                'expanded' => true
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'context' => 'edit'
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
