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
 * @package AppBundle\Controller
 *
 * @Route("/switch-user", name="app.admin.switch_user.")
 * @Security("has_role('ROLE_ALLOWED_TO_SWITCH')")
 */
class SwitchUserController extends AbstractController
{
    /**
     * @Route(path="/form", name="form")
     * @param Request $request
     * @return Response
     */
    public function form(Request $request)
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