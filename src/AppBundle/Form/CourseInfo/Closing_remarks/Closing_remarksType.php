<?php


namespace AppBundle\Form\CourseInfo\Closing_remarks;


use AppBundle\Entity\CourseInfo;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Closing_remarksType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('closingRemarks', CKEditorType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('closingVideo', TextareaType::class, [
                'required' => false,
                'label' => "Intégration de contenu vidéo / audio"
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