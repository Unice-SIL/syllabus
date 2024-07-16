<?php

namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Entity\User;
use App\Syllabus\Form\Filter\UserFilterType;
use App\Syllabus\Form\UserType;
use App\Syllabus\Helper\MailHelper;
use App\Syllabus\Manager\UserManager;
use App\Syllabus\Repository\Doctrine\UserDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * User controller.
 *
 * @Route("/user", name="app.admin.user.")
 * @Security("is_granted('ROLE_ADMIN_USER')")
 */
class UserController extends AbstractController
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_USER_LIST')")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param UserDoctrineRepository $userDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        PaginatorInterface $paginator,
        UserDoctrineRepository $userDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    ): Response
    {
        $qb = $userDoctrineRepository->getIndexQueryBuilder();
        $form = $this->createForm(UserFilterType::class);

        if ($request->query->has($form->getName())) {

            // manually bind values from the request
            $form->submit($request->query->get($form->getName()));
            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }


        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('user/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/new", name="new")
     * @Security("is_granted('ROLE_ADMIN_USER_CREATE')")
     *
     * @param Request $request
     * @param UserManager $userManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, UserManager $userManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $user = $userManager->new();
        $form = $this->createForm(UserType::class, $user, ['context' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $userManager->create($user);
            $this->addFlash('success', $translator->trans('admin.user.flashbag.new'));

            return $this->redirectToRoute('app.admin.user.index');
        }

        return $this->render('user/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="edit"), methods={"GET", "POST"}
     * @Security("is_granted('ROLE_ADMIN_USER_UPDATE')")
     *
     * @param Request $request
     * @param User $user
     * @param UserManager $userManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, User $user, UserManager $userManager, TranslatorInterface $translator): RedirectResponse|Response
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
    public function sendPasswordToken(User $user, UserManager $userManager, MailHelper $mailer, TranslatorInterface $translator): RedirectResponse
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
