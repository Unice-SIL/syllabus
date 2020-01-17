<?php

namespace AppBundle\Form\CourseInfo\Presentation;


use AppBundle\Constant\Level;
use AppBundle\Entity\CourseInfo;
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

class GeneralType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('period', TextType::class, [
                'label' => 'Période (facultatif)',
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
                'label' => 'En quelle(s) langue(s) est dispensé ce cours (facultatif)',
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
            ->add('mediaType', HiddenType::class)
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