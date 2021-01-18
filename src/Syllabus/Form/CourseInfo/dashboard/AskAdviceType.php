<?php


namespace AppBundle\Form\CourseInfo\dashboard;


use AppBundle\Entity\AskAdvice;
use AppBundle\Form\Subscriber\AskAdviceTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AskAdviceType extends AbstractType
{
    private $askAdviceTypeSubscriber;

    public function __construct(AskAdviceTypeSubscriber $askAdviceTypeSubscriber)
    {
        $this->askAdviceTypeSubscriber = $askAdviceTypeSubscriber;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => false,
            ])
            ->addEventSubscriber($this->askAdviceTypeSubscriber);
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => AskAdvice::class
        ));
    }
}