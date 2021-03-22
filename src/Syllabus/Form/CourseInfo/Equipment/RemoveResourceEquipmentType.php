<?php


namespace App\Syllabus\Form\CourseInfo\Equipment;


use App\Syllabus\Entity\CourseResourceEquipment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoveResourceEquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {}

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseResourceEquipment::class,
            'csrf_token_id' => 'delete_equipment'
        ]);
    }
}