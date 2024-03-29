<?php


namespace App\Syllabus\Form\Type;


use App\Syllabus\Form\DataTransformer\CourseWithHierarchyTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CourseWithHierarchyType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $transformer;
    private $generator;


    public function __construct(CourseWithHierarchyTransformer $transformer, UrlGeneratorInterface $generator)
    {
        $this->transformer = $transformer;
        $this->generator = $generator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', null, [
                'attr' => [
                    'class' => 'autocomplete-input',
                    'data-autocomplete-path' => $this->generator->generate('app.admin.course.autocomplete', ['field' => 'code'])
                ]
            ])
            /*
            ->add('parents', Select2EntityType::class, [
                'label' => 'app.form.course.label.parents',
                'multiple' => true,
                'remote_route' => 'app_admin_course_autocompleteS2',
                'class' => Course::class,
                'text_property' => 'code',
                'page_limit' => 10,
                'placeholder' => 'Choisissez une code établissement',
                'required' => true,
            ])
            */
            ;


        $builder->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'Le code établissement ne correspond a aucun cours.',
        ]);
    }


}