<?php


namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Form\SwitchUserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StructureController
 * @package App\Syllabus\Controller
 *
 * @Security("is_granted('ROLE_ALLOWED_TO_SWITCH')")
 */
#[Route(path: '/switch-user', name: 'app.admin.switch_user.')]
class SwitchUserController extends AbstractController
{
    #[Route(path: '/form', name: 'form')]
    public function form(Request $request): Response
    {
        $form = $this->createForm(SwitchUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            return $this->redirect($this->generateUrl('app_index').'?_switch_user='.$data['username']->getUsername());
        }

        return $this->render('switch_user/switch_user.html.twig', [
            'form' => $form->createView()
        ]);
    }
}