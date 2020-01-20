<?php

namespace AppBundle\Form\CourseInfo\Permission;

use AppBundle\Constant\Permission;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class AddCourseInfoPermissionType extends AbstractType
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
            ->add('user', Select2EntityType::class, [
                'label' => 'app.form.course_permission.label.user',
                'multiple' => false,
                'remote_route' => 'app_admin_user_autocompleteS2',
                'class' => User::class,
                'text_property' => 'getSelect2Name',
                'page_limit' => 10,
                'placeholder' => 'Choisissez un utilisateur',
                'required' => true,
            ])
            ->add('permission', ChoiceType::class, [
                'label' => 'app.form.course_permission.label.permission',
                'choices' => array_combine(Permission::PERMISSIONS, Permission::PERMISSIONS),
                'choice_label' => function ($choice, $key, $value) {
                    return 'app.const.permission.'.$key;
                },
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
        return 'appbundle_add_course_info_permission';
    }


}
