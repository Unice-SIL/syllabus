<?php

namespace App\Syllabus\Form;

use App\Syllabus\Form\Subscriber\ActivityTypeSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{

    private ActivityTypeSubscriber $activityTypeSubscriber;

    public function __construct(ActivityTypeSubscriber $activityTypeSubscriber)
    {
        $this->activityTypeSubscriber = $activityTypeSubscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
            ->add('description')
            ->add('activityTypes', EntityType::class, [
                'label' => 'admin.activity.form.activityTypes',
                'class' => \App\Syllabus\Entity\ActivityType::class,
                'multiple' => true,
                'by_reference' => false
            ])
            ->addEventSubscriber($this->activityTypeSubscriber);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Syllabus\Entity\Activity'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'appbundle_activity';
    }


}
