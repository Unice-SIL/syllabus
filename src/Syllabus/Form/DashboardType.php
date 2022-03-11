<?php


namespace App\Syllabus\Form;


use App\Syllabus\Manager\YearManager;
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
                'label' => "admin.dashboard.form.years",
                'choices' => $this->manager->findAll(),
                'choice_label' => 'label',
                'choice_value' => 'id',
                'data' => $this->manager->findCurrentYear(),
                'required' => true
            ]);
    }
}