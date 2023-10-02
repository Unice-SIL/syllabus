<?php


namespace App\Syllabus\Form;


use App\Syllabus\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 *
 */
class SearchSyllabusType extends AbstractType
{
    /**
     * @var null|Request
     */
    private $request;

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
        $builder->add('courses', Select2EntityType::class, [
            'label' => false,
            'remote_route' => 'app.common.autocomplete.generic_s2_courses',
            'required' => false,
            'multiple' => false,
            'mapped' => false,
            'class' => Course::class,
            'primary_key' => 'id',
            'text_property' => 'title',
            'language' => $this->request->getLocale(),
            'minimum_input_length' => 4,
            'remote_params' => [
                'entityName' => 'Course',
                'property' => 'title',
                'property_optional' => 'code'
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'label' => false
        ));
    }
}