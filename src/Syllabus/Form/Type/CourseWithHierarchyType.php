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
     * @var CourseWithHierarchyTransformer
     */
    private CourseWithHierarchyTransformer $transformer;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $generator;


    public function __construct(CourseWithHierarchyTransformer $transformer, UrlGeneratorInterface $generator)
    {
        $this->transformer = $transformer;
        $this->generator = $generator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', null, [
                'attr' => [
                    'class' => 'autocomplete-input',
                    'data-autocomplete-path' => $this->generator->generate('app.admin.course.autocomplete', ['field' => 'code'])
                ]
            ]);


        $builder->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'invalid_message' => 'Le code établissement ne correspond a aucun cours.',
        ]);
    }


}