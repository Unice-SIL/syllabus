<?php


namespace AppBundle\Form;


use AppBundle\Constant\Language;
use AppBundle\Form\Subscriber\LanguageTypeSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguageType extends AbstractType
{
    private $languageTypeSubscriber;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * PeriodType constructor.
     * @param LanguageTypeSubscriber $languageTypeSubscriber
     * @param EntityManagerInterface $em
     */
    public function __construct(LanguageTypeSubscriber $languageTypeSubscriber, EntityManagerInterface $em)
    {
        $this->languageTypeSubscriber = $languageTypeSubscriber;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('locale', ChoiceType::class, [
                'choices' => array_diff(
                    array_combine(Language::LOCALES, Language::LOCALES),
                    array_map(function($language) {
                        return $language->getLocale();
                    }, $this->em->getRepository(\AppBundle\Entity\Language::class)->findAll())
                )
            ])
            ->addEventSubscriber($this->languageTypeSubscriber)
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Language'
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