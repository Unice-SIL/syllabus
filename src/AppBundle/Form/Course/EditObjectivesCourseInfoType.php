<?php

namespace AppBundle\Form\Course;

use AppBundle\Entity\CourseInfo;
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
     * @var CourseInfo
     */
    private $courseInfo;
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
        $this->courseInfo = $builder->getData();
        $builder
            ->add('courseAchievements', CollectionType::class, [
                'label' => false,
                'entry_type' => CourseAchievementType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'mapped' => false
            ])
            ->add('coursePrerequisites', CollectionType::class, [
                'label' => false,
                'entry_type' => CoursePrerequisiteType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('courseTutoringResources', CollectionType::class, [
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
                'label' => 'Infos pratiques (facultatif)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Renseigner ici les dates, lieux, noms des enseignants...'
                ]
            ])->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){
                // Get data
                $data = $event->getData();
                // Sort equipments
                if(array_key_exists('courseAchievements', $data)){
                    $achievements = array_values($data['courseAchievements']);
                    foreach ($achievements as $i => $achievement){
                        $achievements[$i]['order'] = $i+1;
                        $achievements[$i]['courseInfo'] = $this->courseInfo;
                    }
                    $data['courseAchievements'] = $achievements;
                }
                // Sort prerequisites
                if(array_key_exists('coursePrerequisites', $data)){
                    $prerequisites = array_values($data['coursePrerequisites']);
                    foreach ($prerequisites as $i => $prerequisite){
                        $prerequisites[$i]['order'] = $i+1;
                    }
                    $data['coursePrerequisites'] = $prerequisites;
                }
                // Sort prerequisites
                if(array_key_exists('courseTutoringResources', $data)){
                    $tutoringResources = array_values($data['courseTutoringResources']);
                    foreach ($tutoringResources as $i => $tutoringResource){
                        $tutoringResources[$i]['order'] = $i+1;
                    }
                    $data['courseTutoringResources'] = $tutoringResources;
                }
                //Set data
                $event->setData($data);
                dump($data);
            });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseInfo::class,
            'allow_extra_fields ' => true,
        ]);
    }

    public function getName(){
        return EditObjectivesCourseInfoType::class;
    }
}