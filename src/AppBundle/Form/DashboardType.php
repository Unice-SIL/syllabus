<?php


namespace AppBundle\Form;


use AppBundle\Manager\YearManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class DashboardType extends AbstractType
{
    private $manager;

    /**
     * DashboardType constructor.
     */
    public function __construct(YearManager $yearManager)
    {
        $this->manager = $yearManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('years', ChoiceType::class, [
                'label' => "Choisir l'année",
                'choices' => $this->manager->findAll(),
                'choice_label' => 'label',
                'data' => $this->manager->findCurrentYear(),
                'required' => true
            ]);
    }
}