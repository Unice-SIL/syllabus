<?php


namespace AppBundle\Form;


use AppBundle\Constant\UserRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class GroupsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', null, [
                'label' => 'app.form.groups.label.label'
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'app.form.groups.label.roles',
                'choices' => array_combine(UserRole::ROLES, UserRole::ROLES),
                'multiple' => true,
                'expanded' => true,
                'group_by' => function($choice, $key, $value) {
                    if (strpos($choice, 'ROLE_API') === 0) {
                        return 'Api';
                    } elseif (strpos($choice, 'ROLE_ADMIN') === 0)  {
                        return 'Admin';
                    } elseif ($choice === 'ROLE_USER')  {
                        return 'Syllabus';
                    }
                },
            ])
        ;
    }

}