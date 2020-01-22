<?php


namespace AppBundle\Form\CourseInfo\Equipment;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Equipment;
use AppBundle\Form\CourseResourceEquipment\CourseResourceEquipmentType;
use AppBundle\Repository\EquipmentRepositoryInterface;
use Doctrine\ORM\EntityManager;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
{

    /**
     * @var EntityManager
     */
    private $equipmentRepository;

    /**
     * @var array
     */
    private $listEquipments = [];

    public function __construct(
        EquipmentRepositoryInterface $equipmentRepository
    )
    {
        $this->equipmentRepository = $equipmentRepository;

        // list Equipments
        $this->listEquipments = $this->equipmentRepository->findAll();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('listEquipments', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Equipment::class,
                'choices' => $this->listEquipments,
                'choice_label' => 'label',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseInfo::class,
        ]);
    }
}