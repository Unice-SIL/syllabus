<?php


namespace App\Syllabus\Controller;


use App\Syllabus\Entity\User;
use App\Syllabus\Form\Security\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class SecurityController
 * @package App\Syllabus\Controller
 */
#[Route(name: 'app.security.')]
class SecurityController extends AbstractController
{
    
    #[Route(path: '/reset-password/{token}', name: 'reset_password')]
    public function resetPassword(
        Request $request,
        string $token,
        UserPasswordHasherInterface $passwordEncoder,
        EntityManagerInterface $manager,
        TranslatorInterface $translator
    ): Response
    {
        $user = new User();
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {

            $password = $user->getPassword();
            $user = $manager->getRepository(User::class)->findOneByResetPasswordToken($token);

            /* @var $user User */
            if ($user === null) {
                $this->addFlash('danger', $translator->trans('app.controller.security.unknown_token'));
                return $this->redirectToRoute('app.security.reset_password', ['token' => $token]);
            }

            $user->setResetPasswordToken(null);
            $user->setPassword($passwordEncoder->hashPassword($user, $password));
            $manager->flush();


            return $this->redirectToRoute('app.security.reset_password_success');
        }else {

            return $this->render('security/reset_password.html.twig', ['token' => $token, 'form' => $form->createView()]);
        }

    }

    #[Route(path: '/reset-password-success', name: 'reset_password_success', methods: ['GET'])]
    public function resetPasswordSuccess(): Response
    {
        return $this->render('security/reset_password_success.html.twig');
    }
}