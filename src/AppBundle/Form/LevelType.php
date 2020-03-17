<?php


namespace AppBundle\Form;


use AppBundle\Form\Subscriber\LevelTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LevelType extends AbstractType
{
    private $languageTypeSubscriber;

    /**
     * PeriodType constructor.
     * @param LevelTypeSubscriber $languageTypeSubscriber
     */
    public function __construct(LevelTypeSubscriber $languageTypeSubscriber)
    {
        $this->languageTypeSubscriber = $languageTypeSubscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->addEventSubscriber($this->languageTypeSubscriber)
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Level'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_level';
    }
}