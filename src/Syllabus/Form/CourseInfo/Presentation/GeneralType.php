<?php

namespace App\Syllabus\Form\CourseInfo\Presentation;


use App\Syllabus\Entity\Campus;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Domain;
use App\Syllabus\Entity\Language;
use App\Syllabus\Entity\Level;
use App\Syllabus\Entity\Period;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class GeneralType
 * @package AppBundle\Form\CourseInfo\Presentation
 */
class GeneralType extends AbstractType
{
    /**
     * @var null|Request
     */
    private $request;

    /**
     * GeneralType constructor.
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $media = $options['media'];
        if (!$media)
        {
            $media = 'image';
        }
        $builder
            ->add('structure', HiddenType::class, [
                'disabled' => true,
            ])
            ->add('periods', Select2EntityType::class, [
                'label' => 'app.presentation.form.general.periods',
                'multiple' => true,
                'remote_route' => 'app.common.autocomplete.generic_s2',
                'class' => Period::class,
                'text_property' => 'label',
                'language' => $this->request->getLocale(),
                'minimum_input_length' => 0,
                'remote_params' => [
                    'entityName' => 'Period',
                    'findByOther' => ['obsolete' => false, 'structure' => $builder->getData()->getStructure()->getId()]
                ],
                'required' => false
            ])
            ->add('domains', Select2EntityType::class, [
                'label' => 'app.presentation.form.general.domains',
                'multiple' => true,
                'remote_route' => 'app.common.autocomplete.generic_s2',
                'class' => Domain::class,
                'text_property' => 'label',
                'language' => $this->request->getLocale(),
                'minimum_input_length' => 0,
                'remote_params' => [
                    'entityName' => 'Domain',
                    'groupProperty' => 'grp',
                    'findByOther' => ['obsolete' => false, 'structure' => $builder->getData()->getStructure()->getId()]
                ],
                'required' => false
            ])
            ->add('languages', Select2EntityType::class, [
                'multiple' => true,
                'remote_route' => 'app.common.autocomplete.generic_s2',
                'class' => Language::class,
                'text_property' => 'label',
                'label' => 'app.presentation.form.general.languages',
                'language' => $this->request->getLocale(),
                'minimum_input_length' => 0,
                'remote_params' => [
                    'entityName' => 'Language',
                    'findByOther' => ['obsolete' => false]
                ],
                'required' => false
            ])
            ->add('campuses', Select2EntityType::class, [
                'multiple' => true,
                'remote_route' => 'app.common.autocomplete.generic_s2',
                'class' => Campus::class,
                'text_property' => 'label',
                'label' => 'app.presentation.form.general.campuses',
                'language' => $this->request->getLocale(),
                'minimum_input_length' => 0,
                'remote_params' => [
                    'entityName' => 'Campus',
                    'findByOther' => ['obsolete' => false],
                    'groupProperty' => 'grp'
                ],
                'required' => false
            ])
            ->add('levels', Select2EntityType::class, [
                'label' => 'app.presentation.form.general.levels',
                'class' => Level::class,
                'remote_route' => 'app.common.autocomplete.generic_s2',
                'required' => false,
                'multiple' => true,
                'text_property' => 'label',
                'language' => $this->request->getLocale(),
                'minimum_input_length' => 0,
                'remote_params' => [
                    'entityName' => 'Level',
                    'findByOther' => ['obsolete' => false, 'structure' => $builder->getData()->getStructure()->getId()]
                ],
            ])
            ->add('summary', CKEditorType::class, [
                'label' => 'app.presentation.form.general.description',
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
                'data' => $media,
                'choices' => [
                    'app.presentation.form.general.picture' => 'image',
                    'app.presentation.form.general.video' => 'video'
                ]
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'label' => false
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
                'label' => false,
                'attr' => ['rows' => 5],
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseInfo::class,
            'media' => null
        ]);
    }

}