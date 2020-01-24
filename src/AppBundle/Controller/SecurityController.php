<?php


namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\Security\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @return Response
     *
     * @Route("/reset-password/{token}", name="reset_password")
     */
    public function resetPassword(
        Request $request,
        string $token,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $manager
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
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('app.security.reset_password', ['token' => $token]);
            }

            $user->setResetPasswordToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $password));
            $manager->flush();

            $this->addFlash('info', 'Mot de passe mis à jour');

            return $this->redirectToRoute('app_admin_course_info_index');
        }else {

            return $this->render('security/reset_password.html.twig', ['token' => $token, 'form' => $form->createView()]);
        }

    }
}