<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Helper\MailHelper;
use AppBundle\Manager\UserManager;
use AppBundle\Repository\Doctrine\UserDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * User controller.
 *
 * @Route("/admin/user", name="app_admin_user_")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="index")
     * @Method("GET")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $pagination = $this->get('knp_paginator')->paginate(
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
     */
    public function newAction(Request $request, EntityManagerInterface $em, UserManager $userManager)
    {
        $user = $userManager->create();
        $form = $this->createForm(UserType::class, $user, ['context' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été enregistré');

            return $this->redirectToRoute('app_admin_user_edit', ['id' => $user->getId()]);
        }


        return $this->render('user/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été modifié.');

            return $this->redirectToRoute('app_admin_user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/autocompleteS2", name="autocompleteS2", methods={"GET"})
     *
     * @param UserDoctrineRepository $userDoctrineRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function autocompleteS2(UserDoctrineRepository $userDoctrineRepository, Request $request)
    {
        $query = $request->query->get('q');

        $field = $request->query->get('field_name');
        switch ($field) {
            default:
                $searchFields = ['u.firstname', 'u.lastname'];
                break;
        }

        $users = $userDoctrineRepository->findLikeQuery($query, $searchFields);

        $data = array_map(function ($u) use ($request) {
            return ['id' => $u->getId(), 'text' => $u->getSelect2Name()];
        }, $users);

        return $this->json($data);
    }

    /**
     * @Route("/{id}/send-password-token", name="send_password_token", methods={"GET"})
     * @param User $user
     * @param UserManager $userManager
     * @param MailHelper $mailer
     * @return RedirectResponse
     */
    public function sendPasswordToken(User $user, UserManager $userManager, MailHelper $mailer)
    {
        $token = $userManager->setResetPasswordToken($user, ['flush' => true]);

        if ($mailer->sendResetPasswordMessage($user, $token)) {
            $this->addFlash('success', 'Le mail a bien été envoyé.');
            return $this->redirectToRoute('app_admin_user_edit', ['id' => $user->getId()]);
        }

        $this->addFlash('danger', 'Un problème est survenu lors de l\'envoie du mail.');
        return $this->redirectToRoute('app_admin_user_edit', ['id' => $user->getId()]);

    }
}
