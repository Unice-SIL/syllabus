<?php


namespace App\Syllabus\Form\CourseInfo\CourseAchievement;


use App\Syllabus\Entity\CourseTutoringResource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CourseTutoringResourcesType
 * @package App\Syllabus\Form\CourseInfo\CourseAchievement
 */
class CourseTutoringResourcesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => 'app.prerequisites.form.tutoring_resources_description',
                'required' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseTutoringResource::class,
            'csrf_token_id' => 'create_edit_tutoring_resources'
        ]);
    }
}