<?php

namespace AppBundle\Form\Course;

use AppBundle\Command\Course\EditClosingRemarksCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EditClosingRemarksCourseInfoType
 * @package AppBundle\Form\Course
 */
class EditClosingRemarksCourseInfoType extends AbstractType
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
                'label' => "Intégration de contenu vidéo / audio",
                'attr' => ['rows' => 4],
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseInfo::class,
            'allow_extra_fields' => true,
        ]);
    }

    /**
     * @return string
     */
    public function getName(){
        return EditClosingRemarksCourseInfoType::class;
    }
}