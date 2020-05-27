<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Helper\MailHelper;
use AppBundle\Manager\UserManager;
use AppBundle\Repository\Doctrine\UserDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * User controller.
 *
 * @Route("/user", name="app.admin.user.")
 * @Security("has_role('ROLE_ADMIN_USER')")
 */
class UserController extends AbstractController
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="index", methods={"GET"})
     * @Security("has_role('ROLE_ADMIN_USER_LIST')")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function indexAction(
        Request $request,
        PaginatorInterface $paginator
    )
    {
        $pagination = $paginator->paginate(
            $this->getDoctrine()->getManager()->createQuery("SELECT u FROM AppBundle:User u"),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('user/index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * @Route("/new", name="new")
     * @Security("has_role('ROLE_ADMIN_USER_CREATE')")
     *
     * @param Request $request
     * @param UserManager $userManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, UserManager $userManager, TranslatorInterface $translator)
    {
        $user = $userManager->new();
        $form = $this->createForm(UserType::class, $user, ['context' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $userManager->create($user);
            $this->addFlash('success', $translator->trans('admin.user.flashbag.new'));

            return $this->redirectToRoute('app.admin.user.edit', ['id' => $user->getId()]);
        }

        return $this->render('user/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="edit"), methods={"GET", "POST"}
     * @Security("has_role('ROLE_ADMIN_USER_UPDATE')")
     *
     * @param Request $request
     * @param User $user
     * @param UserManager $userManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, User $user, UserManager $userManager, TranslatorInterface $translator)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->update($user);

            $this->addFlash('success', $translator->trans('admin.user.flashbag.edit'));

            return $this->redirectToRoute('app.admin.user.edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/send-password-token", name="send_password_token", methods={"GET"})
     * @param User $user
     * @param UserManager $userManager
     * @param MailHelper $mailer
     * @param TranslatorInterface $translator
     * @return RedirectResponse
     */
    public function sendPasswordToken(User $user, UserManager $userManager, MailHelper $mailer, TranslatorInterface $translator)
    {
        $token = $userManager->setResetPasswordToken($user, ['flush' => true]);

        if ($mailer->sendResetPasswordMessage($user, $token)) {
            $this->addFlash('success', $translator->trans('admin.user.flashbag.mail_send'));
            return $this->redirectToRoute('app.admin.user.edit', ['id' => $user->getId()]);
        }

        $this->addFlash('danger', $translator->trans('admin.user.flashbag.mail_failed'));
        return $this->redirectToRoute('app.admin.user.edit', ['id' => $user->getId()]);

    }
}
