<?php

namespace App\Syllabus\Form\CourseInfo\Permission;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class AddCourseInfoPermissionType
 * @package App\Syllabus\Form\CourseInfo\Permission
 */
class AddCourseInfoPermissionType extends AbstractType
{
    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var UrlGeneratorInterface
     */
    private  $generator;

    /**
     * AddCourseInfoPermissionType constructor.
     * @param UrlGeneratorInterface $generator
     * @param RequestStack $requestStack
     */
    public function __construct(UrlGeneratorInterface $generator, RequestStack $requestStack)
    {
        $this->generator = $generator;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', Select2EntityType::class, [
                'label' => 'app.form.course_permission.label.user',
                'multiple' => false,
                'remote_route' => 'app.common.autocomplete.generic_s2_user',
                'class' => User::class,
                'text_property' => 'getSelect2Name',
                'page_limit' => 10,
                'placeholder' => 'app.permission.modal.placeholder',
                'language' => $this->request->getLocale(),
                'minimum_input_length' => 4,
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
