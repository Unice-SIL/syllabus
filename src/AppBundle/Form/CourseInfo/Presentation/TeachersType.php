<?php

namespace AppBundle\Form\CourseInfo\Presentation;

use AppBundle\Entity\CourseTeacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class TeachersType
 * @package AppBundle\Form\CourseInfo\Presentation
 */
class TeachersType extends AbstractType
{
    /**
     * @var array
     */
    private $teacherSources = [];

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * EditPresentationCourseInfoType constructor.
     * @param $courseTeacherFactory
     * @param RequestStack $requestStack
     * @param TranslatorInterface $translator
     */
    public function __construct(
        $courseTeacherFactory,
        RequestStack $requestStack,
        TranslatorInterface $translator
    )
    {
        $this->translator = $translator;
        $this->requestStack = $requestStack;
        if(is_array($courseTeacherFactory) && array_key_exists('sources', $courseTeacherFactory)){
            foreach ($courseTeacherFactory['sources'] as $id => $source){
                if(is_array($source) && array_key_exists('name', $source)){
                    $this->teacherSources[$source['name']] = $id;
                }else{
                    $this->teacherSources[$id] = $id;
                }
            }
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('teacherSource', ChoiceType::class, [
            'label' => 'app.presentation.form.teacher.source_data',
            'mapped' => false,
            'multiple' => false,
            'expanded' => false,
            'choices' => $this->teacherSources
        ])
            ->add('login', ChoiceType::class,[
                'label' => 'app.presentation.form.teacher.search_user',
                'expanded' => false,
                'multiple' => false,
                'mapped' => false,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){
                $form = $event->getForm();
                $data = $event->getData();

                if(!array_key_exists('login', $data) || is_null($data['login'])){
                    return;
                }
                $form->add('login', ChoiceType::class, [
                    'label' => 'app.presentation.form.teacher.search_user',
                    'expanded' => false,
                    'multiple' => false,
                    'mapped' => false,
                    'choices' => [
                        $data['login'] => $data['login']
                    ]
                ]);
            })
            ->add('emailVisibility', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-style' => 'ios',
                    'data-on' => $this->translator->trans('yes'),
                    'data-off' => $this->translator->trans('no'),
                    'data-width' => 60
                ]
            ])
            ->add('manager', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-style' => 'ios',
                    'data-on' => $this->translator->trans('yes'),
                    'data-off' => $this->translator->trans('no'),
                    'data-width' => 60
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseTeacher::class,
            'allow_extra_fields' => true
        ]);
    }

}