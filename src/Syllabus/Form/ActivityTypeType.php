<?php


namespace App\Syllabus\Form;


use App\Syllabus\Entity\ActivityMode;
use App\Syllabus\Form\Subscriber\ActivityTypeTypeSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityTypeType extends AbstractType
{
    private ActivityTypeTypeSubscriber $activityTypeTypeSubscriber;

    public function __construct(ActivityTypeTypeSubscriber $activityTypeTypeSubscriber)
    {
        $this->activityTypeTypeSubscriber = $activityTypeTypeSubscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $icon = $options['icon'];

        $builder
            ->add('label')
            ->add('activityModes', EntityType::class, [
                'class' => ActivityMode::class,
                'multiple' => true,
                'by_reference' => false,
                'required' => false
            ])
            ->add('icon', FileType::class, [
                'label' => 'Icone',
                'required' => false,
                'data' => $icon,
                'data_class' => null
            ])
            ->addEventSubscriber($this->activityTypeTypeSubscriber)
        ;

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Syllabus\Entity\ActivityType',
            'icon' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'appbundle_activity_type';
    }
}