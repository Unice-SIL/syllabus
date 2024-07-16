<?php


namespace App\Syllabus\Form;


use App\Syllabus\Entity\Structure;
use App\Syllabus\Form\Subscriber\PeriodTypeSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PeriodType
 * @package App\Syllabus\Form
 */
class PeriodType extends AbstractType
{
    /**
     * @var PeriodTypeSubscriber
     */
    private PeriodTypeSubscriber $periodTypeSubscriber;

    /**
     * PeriodType constructor.
     * @param PeriodTypeSubscriber $periodTypeSubscriber
     */
    public function __construct(PeriodTypeSubscriber $periodTypeSubscriber)
    {
        $this->periodTypeSubscriber = $periodTypeSubscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
            ->add('structures', EntityType::class, [
                'label' => "admin.period.form.structure",
                'class' => Structure::class,
                'multiple' => true,
                'by_reference' => false,
                'required' => false
            ])
            ->addEventSubscriber($this->periodTypeSubscriber)
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Syllabus\Entity\Period'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'appbundle_period';
    }
}