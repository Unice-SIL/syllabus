<?php

namespace AppBundle\Form\CourseResourceEquipment;


use AppBundle\Command\CourseResourceEquipment\CourseResourceEquipmentCommand;
use AppBundle\Entity\CourseResourceEquipment;
use AppBundle\Entity\Equipment;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CourseResourceEquipmentType
 * @package AppBundle\Form\CourseResourceEquipment
 */
class CourseResourceEquipmentType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $syllabusEntityManager;

    /**
     * CourseResourceEquipmentType constructor.
     * @param EntityManager $syllabusEntityManager
     */
    public function __construct(EntityManager $syllabusEntityManager)
    {
        $this->syllabusEntityManager = $syllabusEntityManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('equipment', EntityType::class, [
                'class' => Equipment::class,
                'choice_label' => 'label',
                'attr' => [
                    'hidden ' => true
                ],
                'em' => $this->syllabusEntityManager
            ])
            ->add('position', HiddenType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseResourceEquipment::class,
        ]);
    }

    public function getName(){
        return CourseResourceEquipmentType::class;
    }
}