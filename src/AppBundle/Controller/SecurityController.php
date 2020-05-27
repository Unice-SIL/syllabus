<?php


namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\Security\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class SecurityController
 * @package AppBundle\Controller
 *
 * @Route(name="app.security.")
 */
class SecurityController extends Controller
{
    /**
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $manager
     * @param TranslatorInterface $translator
     * @return Response
     *
     * @Route("/reset-password/{token}", name="reset_password")
     */
    public function resetPassword(
        Request $request,
        string $token,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $manager,
        TranslatorInterface $translator
    )
    {
        $user = new User();
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($request->isMethod('POST') and $form->isSubmitted() and $form->isValid()) {

            $password = $user->getPassword();
            $user = $manager->getRepository(User::class)->findOneByResetPasswordToken($token);

            /* @var $user User */
            if ($user === null) {
                $this->addFlash('danger', $translator->trans('app.controller.security.unknown_token'));
                return $this->redirectToRoute('app.security.reset_password', ['token' => $token]);
            }

            $user->setResetPasswordToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $password));
            $manager->flush();


            return $this->redirectToRoute('app.security.reset_password_success');
        }else {

            return $this->render('security/reset_password.html.twig', ['token' => $token, 'form' => $form->createView()]);
        }

    }

    /**
     * @return Response
     * @Route("/reset-password-success", name="reset_password_success", methods={"GET"})
     */
    public function resetPasswordSuccess()
    {
        return $this->render('security/reset_password_success.html.twig');
    }
}