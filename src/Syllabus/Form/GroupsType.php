<?php


namespace App\Syllabus\Form;


use App\Syllabus\Constant\UserRole;
use App\Syllabus\Entity\Groups;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use function foo\func;
use function GuzzleHttp\Promise\some;

class GroupsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fn = function($values, $arr = []) use (&$fn)
        {
            foreach ($values as $key => $value)
            {
                if(!is_array($value))
                {
                    $arr[$value] = $value;
                }else{
                    $arr[$key][$key] = $key;
                    $arr[$key][] = $fn($value);
                }
            }
            return $arr;
        };

        $choices = array_combine(UserRole::ROLES, UserRole::ROLES);
        ksort($choices);

        $builder
            ->add('label', null, [
                'label' => 'app.form.groups.label.label'
            ])
            ->add('roles', ChoiceType::class, [
                'required' => false,
                'label' => 'app.form.groups.label.roles',
                'choices' => $choices,
                'multiple' => true,
                'expanded' => true,
            ])
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var Groups $groups */
            $groups = $event->getData();
            $form = $event->getForm();

            //If not new (then edit mode)
            if (!$groups || null !== $groups->getId()) {
                $form->add('obsolete', CheckboxType::class, [
                    'label' => 'app.form.groups.label.obsolete',
                    'required' => false,
                    'label_attr' => [
                        'class' => 'custom-control-label'
                    ],
                    'attr' => [
                        'class' => 'custom-control-input'
                    ]
                ]);
            }
        });
    }

}