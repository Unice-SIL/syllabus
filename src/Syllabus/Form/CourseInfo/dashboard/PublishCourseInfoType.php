<?php


namespace AppBundle\Form\CourseInfo\dashboard;


use AppBundle\Entity\CourseInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class PublishCourseInfoType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var CourseInfo $courseInfo */
        $courseInfo = $builder->getData();

        if (!$courseInfo instanceof CourseInfo) {
            throw new \Exception('You have to pass a CourseInfo instance as data');
        }

        $builder->add('publish', HiddenType::class, [
            'mapped' => false,
            'attr'=>array('style'=>'display:none')
        ]);


        /*

        $builder->add('publish', CheckboxType::class, [
            'mapped' => false,
            'label' => false,
            'required' => false,
            'attr' => [
                'data-toggle' => 'toggle',
                'data-onstyle' => 'primary',
                'data-on' => $this->translator->trans('app.dashboard.label.publication_label_yes'),
                'data-off' => $this->translator->trans('app.dashboard.label.publication_label_no'),
                'checked' => $courseInfo->getPublicationDate() === null ? false : true,
            ]
        ]);
        */
    }
}