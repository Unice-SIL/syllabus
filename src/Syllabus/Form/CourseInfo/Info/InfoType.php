<?php


namespace App\Syllabus\Form\CourseInfo\Info;


use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class InfoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('agenda', CKEditorType::class, [
                'label' => 'app.info.form.agenda',
                'required' => false,
            ])
            ->add('organization', CKEditorType::class, [
                'label' => 'app.info.form.organization',
                'required' => false,
            ]);
    }
}