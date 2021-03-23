<?php

namespace App\Syllabus\Form\CourseInfo\Activities;

use App\Syllabus\Entity\CourseSection;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddSectionType
 * @package App\Syllabus\Form\CourseInfo\Activities
 */
class SectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', CKEditorType::class, [
            'label' => 'app.activities.form.section.description',
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
            ->add('title', TextType::class, [
                'label' => "app.activities.form.section.title"
            ])
            ->add('url', TextType::class, [
                'label' => "app.activities.form.section.url",
                'required' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseSection::class,
            'allow_extra_fields' => true,
            'csrf_token_id' => 'create_edit_section'
        ]);
    }
}