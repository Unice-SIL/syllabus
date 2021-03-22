<?php


namespace App\Syllabus\Form\CourseInfo\CourseAchievement;


use App\Syllabus\Entity\LearningAchievement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LearningAchievementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => true
            ])
            ->add('score', IntegerType::class, [
                'label' => 'Score :',
                'required' => true
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LearningAchievement::class,
            'csrf_token_id' => 'create_edit_learning_achievement'
        ]);
    }
}