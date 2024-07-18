<?php


namespace App\Syllabus\Form\CourseInfo\Equipment;


use App\Syllabus\Entity\CourseResourceEquipment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoveResourceEquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {}

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseResourceEquipment::class,
            'csrf_token_id' => 'delete_equipment'
        ]);
    }
}