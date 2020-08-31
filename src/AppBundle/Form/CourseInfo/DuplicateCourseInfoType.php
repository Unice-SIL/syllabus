<?php

namespace AppBundle\Form\CourseInfo;

use AppBundle\Entity\CourseInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class DuplicateCourseInfoType
 * @package AppBundle\Form\CourseInfo
 */
class DuplicateCourseInfoType extends AbstractType
{
    /**
     * @var UrlGeneratorInterface
     */
    private  $generator;
    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    private $request;


    /**
     * DuplicateCourseInfoType constructor.
     * @param UrlGeneratorInterface $generator
     * @param RequestStack $request
     */
    public function __construct(UrlGeneratorInterface $generator, RequestStack $request)
    {
        $this->generator = $generator;
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', HiddenType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'required' => true
            ])
            ->add('to', Select2EntityType::class, [
                'label' => 'app.form.duplicate_course_info.label.to',
                'multiple' => false,
                'remote_route' => 'app.common.autocomplete.s2_courseinfo_with_write_permission',
                'class' => CourseInfo::class,
                'text_property' => 'id',
                'language' => $this->request->getLocale(),
                'page_limit' => 10,
                'minimum_input_length' => 4,
                'placeholder' => 'app.dashboard.modal.placeholder',
                'remote_params' => [
                    'currentCourseInfo' => $builder->getData()['currentCourseInfo'],
                ],
                'constraints' => [
                    new NotBlank()
                ],
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'currentCourseInfo' => null
        ]);
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'appbundle_duplicate_course_info';
    }


}
