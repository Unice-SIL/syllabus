<?php

namespace AppBundle\Form\Course;

use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Constant\Level;
use AppBundle\Constant\TeachingMode;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Form\CourseTeacher\CourseTeacherType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class EditCourseInfoType
 * @package AppBundle\Form\Course
 */
class EditPresentationCourseInfoType extends AbstractType
{
    /**
     * @var array
     */
    private $teacherSources = [];
    protected $requestStack;

    /**
     * EditPresentationCourseInfoType constructor.
     * @param $courseTeacherFactory
     */
    public function __construct(
        $courseTeacherFactory,
        RequestStack $requestStack
    )
    {
        $this->requestStack = $requestStack;
        if(is_array($courseTeacherFactory) && array_key_exists('sources', $courseTeacherFactory)){
            foreach ($courseTeacherFactory['sources'] as $id => $source){
                if(is_array($source) && array_key_exists('name', $source)){
                    $this->teacherSources[$source['name']] = $id;
                }else{
                    $this->teacherSources[$id] = $id;
                }
            }
        }
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('period', TextType::class, [
                'label' => 'Période',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Tout le semestre'
                ]
            ])
            ->add('domain', TextType::class, [
                'label' => 'Domaine',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Chimie'
                ]
            ])
            ->add('languages', TextType::class, [
                'label' => 'Langues',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: allemand, russe'
                ]
            ])
            ->add('level', ChoiceType::class, [
                'label' => 'Niveau',
                'required' => false,
                'multiple' => false,
                'expanded' => true,
                'placeholder' => false,
                'choices' => Level::CHOICES
            ])
            ->add('summary', CKEditorType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('teachingMode', ChoiceType::class, [
                'label' => "Mode d'enseignement",
                'expanded'  => true,
                'multiple' => false,
                'choices' => TeachingMode::CHOICES,
                'choice_label' => function($value, $key, $choiceValue){
                    return mb_strtoupper($key);
                }

            ])
            ->add('mediaType', HiddenType::class)
            ->add('image', FileType::class, [
                'required' => false,
                'label' => "Fichier image",
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                dump($form, $data);
                if(!is_null($form->getData()->getImage()) && is_null($data['image'])){
                    $data['image'] = $form->getData()->getImage();
                    $event->setData($data);
                }

            })
            ->add('video', TextareaType::class, [
                'required' => false,
                'label' => "Intégration de contenu vidéo / audio",
                'attr' => ['rows' => 5],
            ])
            ->add('teachingCmClass', TextType::class, [
                'required' => false,
                'disabled' => true,
                'label' => 'h Cours Magistraux',
            ])
            ->add('teachingTdClass', TextType::class, [
                'required' => false,
                'disabled' => true,
                'label' => 'h Travaux Dirigés',
            ])
            ->add('teachingTpClass', TextType::class, [
                'required' => false,
                'disabled' => true,
                'label' => 'h Travaux Pratiques',
            ])
            ->add('teachingOtherClass', TextType::class, [
                'required' => false,
                'label' => 'h Autre (facultatif)',
                'attr' => [
                    'data-teaching-mode' => 'class'
                ]
            ])
            ->add('teachingOtherTypeClass', TextType::class, [
                'required' => false,
                'label' => 'Type',
                'attr' => [
                    'data-teaching-mode' => 'class',
                    'placeholder' => 'Ex: Tutotrat'
                ]
            ])
            ->add('teachingCmHybridClass', TextType::class, [
                'required' => false,
                'label' => 'h Cours Magistraux',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTdHybridClass', TextType::class, [
                'required' => false,
                'label' => 'h Travaux Dirigés',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTpHybridClass', TextType::class, [
                'required' => false,
                'label' => 'h Travaux Pratiques',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherHybridClass', TextType::class, [
                'required' => false,
                'label' => 'h Autre (facultatif)',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherTypeHybridClass', TextType::class, [
                'required' => false,
                'label' => 'Type',
                'attr' => [
                    'data-teaching-mode' => 'hybrid',
                    'placeholder' => 'Ex: Tutotrat'
                ]
            ])
            ->add('teachingCmHybridDist', TextType::class, [
                'required' => false,
                'label' => 'h Cours Magistraux',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTdHybridDist', TextType::class, [
                'required' => false,
                'label' => 'h Travaux Dirigés',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherHybridDist', TextType::class, [
                'required' => false,
                'label' => 'h Autre (facultatif)',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherTypeHybridDistant', TextType::class, [
                'required' => false,
                'label' => 'Type',
                'attr' => [
                    'data-teaching-mode' => 'hybrid',
                    'placeholder' => 'Ex: Tutotrat'
                ]
            ])
            ->add('teacherSource', ChoiceType::class, [
                'mapped' => false,
                'multiple' => false,
                'expanded' => false,
                'choices' => $this->teacherSources
            ])

            ->add('teacherSearch', Select2EntityType::class, [
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'remote_route' => 'search_course_teacher_json',
                'class' => CourseTeacher::class,
                'language' => $this->requestStack->getCurrentRequest()->getLocale(),
                'placeholder' => 'Rechercher un individu',
                'minimum_input_length' => 2,
                'req_params' => ['source' => 'parent.children[teacherSource]'],
            ])
            ->add('teachers', CollectionType::class, [
                'entry_type' => CourseTeacherType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'error_bubbling' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditPresentationCourseInfoCommand::class,
            'allow_extra_fields' => true,
        ]);
    }

    /**
     * @return string
     */
    /*
    public function getBlockPrefix()
    {
        return 'EditPresentationCourseInfoType';
    }
    */
}