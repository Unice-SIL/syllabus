<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Course;
use AppBundle\Form\DataTransformer\CourseWithHierarchyTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

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
            ->add('etbId', null, [
                'attr' => [
                    'class' => 'autocomplete-input',
                    'data-autocomplete-path' => $this->generator->generate('app_admin_course_autocomplete', ['field' => 'etbId'])
                ]
            ])
            ;

        $formModifier = function (FormInterface $form, string $etbId = null) {
            $remote_params = null === $etbId ? [] : ['etbId' => $etbId];

            $form->add('parents', Select2EntityType::class, [
                'label' => 'app.form.course.label.parents',
                'multiple' => true,
                'remote_route' => 'app_admin_course_autocompleteS2',
                'class' => Course::class,
                'text_property' => 'etbId',
                'page_limit' => 10,
                'placeholder' => 'Choisissez une code établissement',
                'required' => true,
                'remote_params' => $remote_params
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {

                $formModifier($event->getForm());
            }
        );

        $builder->get('etbId')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $etbId = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $etbId);
            }
        );
        $builder->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'Soit le code établissement ne correspond a aucun cours, soit vous avez selectionné le 
            cours comme étant son propre parent.',
        ]);
    }


}