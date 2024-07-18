<?php


namespace App\Syllabus\Form\CourseInfo\Closing_remarks;


use App\Syllabus\Entity\CourseInfo;
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
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('closingRemarks', CKEditorType::class, [
                'label' => 'app.closing_remarks.form.closing_remarks',
                'required' => false,
            ])
            ->add('closingVideo', TextareaType::class, [
                'required' => false,
                'label' => "app.closing_remarks.form.closing_video"
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseInfo::class,
        ]);
    }
}