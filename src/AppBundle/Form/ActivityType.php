<?php

namespace AppBundle\Form;

use AppBundle\Form\Subscriber\ActivityTypeSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{

    private $activityTypeSubscriber;

    public function __construct(ActivityTypeSubscriber $activityTypeSubscriber)
    {
        $this->activityTypeSubscriber = $activityTypeSubscriber;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('description')
            ->add('activityTypes', EntityType::class, [
                'label' => "Types d'activité",
                'class' => \AppBundle\Entity\ActivityType::class,
                'multiple' => true,
                'by_reference' => false
            ])
            ->addEventSubscriber($this->activityTypeSubscriber)
        ;

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Activity'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_activity';
    }


}
