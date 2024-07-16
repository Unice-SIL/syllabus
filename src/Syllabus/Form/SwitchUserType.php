<?php


namespace App\Syllabus\Form;

use App\Syllabus\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class SwitchUserType
 * @package App\Form\SwitchUser
 */
class SwitchUserType extends AbstractType
{
    /**
     * @var Request|null
     */
    private ?Request $request;

    /**
     * SwitchUserType constructor.
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
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('username', Select2EntityType::class, [
            'label' => 'app.form.switch_user.username',
            'multiple' => false,
            'remote_route' => 'app.common.autocomplete.generic_s2_user',
            'class' => User::class,
            'text_property' => 'getSelect2Name',
            'page_limit' => 10,
            'placeholder' => 'app.permission.modal.placeholder',
            'language' => $this->request->getLocale(),
            'minimum_input_length' => 4,
            'required' => true,
        ])
            ->add('submit', SubmitType::class, [
                'label' => 'app.form.switch_user.imitate'
            ]);
    }
}