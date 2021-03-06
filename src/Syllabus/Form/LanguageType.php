<?php


namespace App\Syllabus\Form;


use App\Syllabus\Constant\Language;
use App\Syllabus\Form\Subscriber\LanguageTypeSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguageType extends AbstractType
{
    private $languageTypeSubscriber;

    /**
     * PeriodType constructor.
     * @param LanguageTypeSubscriber $languageTypeSubscriber
     */
    public function __construct(LanguageTypeSubscriber $languageTypeSubscriber)
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
            'data_class' => 'App\Syllabus\Entity\Language'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_language';
    }
}