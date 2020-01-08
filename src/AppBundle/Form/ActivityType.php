<?php

namespace AppBundle\Form;

use AppBundle\Constant\ActivityGroup;
use AppBundle\Constant\ActivityMode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label');

            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event)  {

                $form = $event->getForm();
                $activity = $event->getData();

                if ($activity->getType() === \AppBundle\Constant\ActivityType::ACTIVITY) {
                    $modeChoices = ActivityMode::$activityModes;
                    $grpChoices = ActivityGroup::$activityGroups;
                }

                $form->add('mode', ChoiceType::class, [
                    'label' => 'app.form.activity.label.mode',
                    'choices' => array_combine($modeChoices, $modeChoices)
                ])
                    ->add('grp', ChoiceType::class, [
                        'label' => 'app.form.activity.label.grp',
                        'choices' => array_combine($grpChoices, $grpChoices)
                    ])
                ;

            });


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
