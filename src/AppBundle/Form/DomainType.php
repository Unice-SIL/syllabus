<?php


namespace AppBundle\Form;


use AppBundle\Entity\Structure;
use AppBundle\Form\Subscriber\DomainTypeSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomainType extends AbstractType
{
    private $domainTypeSubscriber;

    /**
     * DomainType constructor.
     * @param DomainTypeSubscriber $domainTypeSubscriber
     */
    public function __construct(DomainTypeSubscriber $domainTypeSubscriber)
    {
        $this->domainTypeSubscriber = $domainTypeSubscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('structures', EntityType::class, [
                'label' => "Structure",
                'class' => Structure::class,
                'multiple' => true,
                'by_reference' => false,
                'required' => false
            ])
            ->addEventSubscriber($this->domainTypeSubscriber)
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Domain'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_domain';
    }
}