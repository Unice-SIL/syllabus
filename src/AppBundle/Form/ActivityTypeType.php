<?php


namespace AppBundle\Form;


use AppBundle\Entity\ActivityMode;
use AppBundle\Form\Subscriber\ActivityTypeTypeSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityTypeType extends AbstractType
{
    private $activityTypeTypeSubscriber;

    public function __construct(ActivityTypeTypeSubscriber $activityTypeTypeSubscriber)
    {
        $this->activityTypeTypeSubscriber = $activityTypeTypeSubscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('activityModes', EntityType::class, [
                'class' => ActivityMode::class,
                'multiple' => true,
                'by_reference' => false,
                'required' => false,
                'expanded' => true
            ])
            ->addEventSubscriber($this->activityTypeTypeSubscriber)
        ;

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ActivityType'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_activity_type';
    }
}