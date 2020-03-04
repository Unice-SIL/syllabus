<?php

namespace AppBundle\Form\CourseInfo\Presentation;


use AppBundle\Constant\Level;
use AppBundle\Entity\Campus;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Domain;
use AppBundle\Entity\Language;
use AppBundle\Entity\Period;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class GeneralType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('structure', HiddenType::class, [
                'disabled' => true,
            ])
            ->add('periods', Select2EntityType::class, [
                'label' => 'Période (facultatif)',
                'multiple' => true,
                'remote_route' => 'app_admin_period_autocompleteS2',
                'class' => Period::class,
                'text_property' => 'label',
                'language' => 'fr',
                'minimum_input_length' => 0,
                'remote_params' => [
                    'structure' => $builder->getData()->getStructure()->getId()
                ],
                'required' => false
            ])
            ->add('domains', Select2EntityType::class, [
                'label' => 'Domaine',
                'multiple' => true,
                'remote_route' => 'app_admin_domain_autocompleteS2',
                'class' => Domain::class,
                'text_property' => 'label',
                'language' => 'fr',
                'minimum_input_length' => 0,
                'remote_params' => [
                    'structure' => $builder->getData()->getStructure()->getId()
                ],
                'required' => false
            ])
            ->add('languages', Select2EntityType::class, [
                'multiple' => true,
                'remote_route' => 'app_admin_language_autocompleteS2',
                'class' => Language::class,
                'text_property' => 'label',
                'label' => 'En quelle(s) langue(s) est dispensé ce cours (facultatif)',
                'language' => 'fr',
                'minimum_input_length' => 0,
                'required' => false
            ])
            ->add('campuses', Select2EntityType::class, [
                'multiple' => true,
                'remote_route' => 'app_admin_campus_autocompleteS2',
                'class' => Campus::class,
                'text_property' => 'label',
                'label' => 'Campus',
                'language' => 'fr',
                'minimum_input_length' => 0,
                'required' => false
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
                'config' => array(
                    'extraPlugins' => 'wordcount',
                    'wordcount' => [
                        'showParagraphs' => false,
                        'showCharCount' => true,
                        'maxCharCount' => 2000,
                        'maxWordCount' => 500
                    ]
                ),
                'plugins' => array(
                    'wordcount' => array(
                        'path'     => '/build/ckeditor/plugins/wordcount/',
                        'filename' => 'plugin.js',
                        'maxCharCount' => 10,
                    ),
                ),
            ])
            ->add('mediaType', ChoiceType::class, [
                'label' => 'app.presentation.form.general.media_label',
                'required' => false,
                'multiple' => false,
                'expanded' => true,
                'placeholder' => false,
                'choices' => [
                    'app.presentation.form.general.picture' => 'image',
                    'app.presentation.form.general.video' => 'video'
                ]
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'label' => "Fichier image",
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                if(!is_null($form->getData()->getImage()) && is_null($data['image'])){
                    $data['image'] = $form->getData()->getImage();
                    $event->setData($data);
                }

            })
            ->add('video', TextareaType::class, [
                'required' => false,
                'label' => "Intégration de contenu vidéo / audio",
                'attr' => ['rows' => 5],
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseInfo::class
        ]);
    }

}