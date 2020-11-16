<?php


namespace AppBundle\Form\CourseInfo\Presentation;


use AppBundle\Entity\CourseTeacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class EditTeacherType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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