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
 * @Security("is_granted('ROLE_ADMIN_USER')")
 */
#[Route(path: '/user', name: 'app.admin.user.')]
class UserController extends AbstractController
{
    /**
     * Lists all user entities.
     *
     * @Security("is_granted('ROLE_ADMIN_USER_LIST')")
     *
     */
    #[Route(path: '/', name: 'index', methods: ['GET'])]
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
     * @Security("is_granted('ROLE_ADMIN_USER_CREATE')")
     *
     */
    #[Route(path: '/new', name: 'new')]
    public function newAction(Request $request, UserManager $userManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $user = $userManager->new();
        $form = $this->createForm(UserType::class, $user, ['context' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->create($user);
            $this->addFlash('success', $translator->trans('admin.user.flashbag.new'));

            return $this->redirectToRoute('app.admin.user.index');
        }

        return $this->render('user/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Security("is_granted('ROLE_ADMIN_USER_UPDATE')")
     *
     */
    #[Route(path: '/{id}/edit', name: 'edit')] // , methods={"GET", "POST"}
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

    #[Route(path: '/{id}/send-password-token', name: 'send_password_token', methods: ['GET'])]
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
