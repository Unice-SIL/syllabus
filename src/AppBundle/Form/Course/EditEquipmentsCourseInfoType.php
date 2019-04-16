<?php

namespace AppBundle\Form\Course;

use AppBundle\Command\Course\EditEquipmentsCourseInfoCommand;
use AppBundle\Entity\Equipment;
use AppBundle\Form\CourseResourceEquipment\CourseResourceEquipmentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Repository\EquipmentRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

/**
 * Class EditEquipmentsCourseInfoType
 * @package AppBundle\Form\Course
 */
class EditEquipmentsCourseInfoType extends AbstractType
{

    /**
     * @var EntityManager
     */
    private $equipmentRepository;

    /**
     * @var array
     */
    private $listEquipments = [];

    /**
     * Equipment constructor.
     * @param EquipmentRepositoryInterface $equipmentRepository
     */
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
        ->add('equipments', CollectionType::class, [
            'label' => false,
            'entry_type' => CourseResourceEquipmentType::class,
            'entry_options' => [
                'label' => false,
            ],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ])
        ->add('listEquipments', EntityType::class, [
            'label' => false,
            'mapped' => false,
            'class' => Equipment::class,
            'choices' => $this->listEquipments,
            'choice_label' => 'label',
        ])
        ->add('educationalResources', CKEditorType::class, [
            'label' => 'Description',
            'required' => false,
        ])
        ->add('bibliographicResources', CKEditorType::class, [
            'label' => 'Description',
            'required' => false,
        ])->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){
                // Get data
                $data = $event->getData();
                // Sort equipments
                if(array_key_exists('equipments', $data)){
                    $equipments = array_values($data['equipments']);
                    foreach ($equipments as $i => $equipment){
                        $equipments[$i]['order'] = $i+1;
                    }
                    $data['equipments'] = $equipments;
                }
                //Set data
                $event->setData($data);
            });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditEquipmentsCourseInfoCommand::class,
            'allow_extra_fields' => true,
        ]);
    }

    /**
     * @return string
     */
    public function getName(){
        return EditEquipmentsCourseInfoType::class;
    }
}