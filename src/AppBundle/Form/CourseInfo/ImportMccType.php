<?php


namespace AppBundle\Form\CourseInfo;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class ImportMccType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('csv', FileType::class, [
            'label' => 'app.form.import_mcc.label.csv',
            'label_attr' => [
                'class' => 'custom-file-label'
            ],
            'attr' => [
                'class' => 'custom-file-input',
            ],
            'required' => true,
        ]);
    }

}