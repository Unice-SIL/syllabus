<?php


namespace App\Syllabus\Form;


use App\Syllabus\Entity\Structure;
use App\Syllabus\Form\Subscriber\LevelTypeSubscriber;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LevelType extends AbstractType
{
    private $levelTypeSubscriber;

    /**
     * PeriodType constructor.
     * @param LevelTypeSubscriber $levelTypeSubscriber
     */
    public function __construct(LevelTypeSubscriber $levelTypeSubscriber)
    {
        $this->levelTypeSubscriber = $levelTypeSubscriber;
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
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.label', 'ASC');
                },
                'multiple' => true,
                'by_reference' => false,
                'required' => false
            ])
            ->addEventSubscriber($this->levelTypeSubscriber)
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