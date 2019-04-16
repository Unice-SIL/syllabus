<?php

namespace AppBundle\Form\Course;

use AppBundle\Command\Course\EditObjectivesCourseInfoCommand;
use AppBundle\Form\CourseAchievement\CourseAchievementType;
use AppBundle\Form\CoursePrerequisite\CoursePrerequisiteType;
use AppBundle\Form\CourseTutoringResource\CourseTutoringResourceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EditObjectivesCourseInfoType
 * @package AppBundle\Form\Course
 */
class EditObjectivesCourseInfoType extends AbstractType
{

    /**
     * EditObjectivesCourseInfoType constructor.
     */
    public function __construct(
    )
    {
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('achievements', CollectionType::class, [
                'label' => false,
                'entry_type' => CourseAchievementType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('prerequisites', CollectionType::class, [
                'label' => false,
                'entry_type' => CoursePrerequisiteType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('tutoringResources', CollectionType::class, [
                'label' => false,
                'entry_type' => CourseTutoringResourceType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('tutoring', CheckboxType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                ]
            ])
            ->add('tutoringTeacher', CheckboxType::class, [
                'required' => false,
                'label' => "Avec tuteur enseignant"
            ])
            ->add('tutoringStudent', CheckboxType::class, [
                'required' => false,
                'label' => "Avec tuteur étudiant"
            ])
            ->add('tutoringDescription', TextType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Renseigner ici les dates, lieux, noms des enseignants...'
                ]
            ])->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){
                // Get data
                $data = $event->getData();
                // Sort equipments
                if(array_key_exists('achievements', $data)){
                    $achievements = array_values($data['achievements']);
                    foreach ($achievements as $i => $achievement){
                        $achievements[$i]['order'] = $i+1;
                    }
                    $data['achievements'] = $achievements;
                }
                // Sort prerequisites
                if(array_key_exists('prerequisites', $data)){
                    $prerequisites = array_values($data['prerequisites']);
                    foreach ($prerequisites as $i => $prerequisite){
                        $prerequisites[$i]['order'] = $i+1;
                    }
                    $data['prerequisites'] = $prerequisites;
                }
                // Sort prerequisites
                if(array_key_exists('tutoringResources', $data)){
                    $tutoringResources = array_values($data['tutoringResources']);
                    foreach ($tutoringResources as $i => $tutoringResource){
                        $tutoringResources[$i]['order'] = $i+1;
                    }
                    $data['tutoringResources'] = $tutoringResources;
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
            'data_class' => EditObjectivesCourseInfoCommand::class,
            'allow_extra_fields ' => true,
        ]);
    }

    public function getName(){
        return EditObjectivesCourseInfoType::class;
    }
}