<?php


namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class SwitchUserType
 * @package App\Form\SwitchUser
 */
class SwitchUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, [
            'required' => true,
            'label' => "app.form.switch_user.username"
        ])
            ->add('submit', SubmitType::class, [
                'label' => 'app.form.switch_user.imitate'
            ]);
    }
}