<?php


namespace App\Syllabus\Form;


use App\Syllabus\Form\Subscriber\CampusTypeSubscriber;
use App\Syllabus\Form\Type\CustomCheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampusType extends AbstractType
{
    private CampusTypeSubscriber $campusTypeSubscriber;

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
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
            ->add('grp', TextType::class, [
                'label'=> "Groupe",
                'required' => false
            ])
            ->add('synchronized', CustomCheckboxType::class, [
                'label' => 'admin.campus.synchronized'
            ])
            ->addEventSubscriber($this->campusTypeSubscriber)
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Syllabus\Entity\Campus'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'appbundle_campus';
    }
}