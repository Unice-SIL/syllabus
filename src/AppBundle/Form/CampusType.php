<?php


namespace AppBundle\Form;


use AppBundle\Form\Subscriber\CampusTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampusType extends AbstractType
{
    private $campusTypeSubscriber;

    /**
     * PeriodType constructor.
     * @param CampusTypeSubscriber $campusTypeSubscriber
     */
    public function __construct(CampusTypeSubscriber $campusTypeSubscriber)
    {
        $this->campusTypeSubscriber = $campusTypeSubscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->addEventSubscriber($this->campusTypeSubscriber)
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Campus'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_campus';
    }
}