<?php


namespace AppBundle\Controller\Admin;


use AppBundle\Entity\CourseInfo;
use AppBundle\Form\Filter\SyllabusFilterType;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class SyllabusController
 * @package AppBundle\Controller\Admin
 *
 * @Route("syllabus", name="app.admin.syllabus.")
 * @Security("has_role('ROLE_ADMIN_COURSE')")
 */
class SyllabusController extends Controller
{

    /**
     * @Route("/list", name="index", methods={"GET"})
     * @Security("has_role('ROLE_ADMIN_COURSE_LIST')")
     *
     * @param Request $request
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        CourseInfoDoctrineRepository $courseInfoDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {
        $qb = $courseInfoDoctrineRepository->getIndexQueryBuilder();
        $form = $this->createForm(SyllabusFilterType::class, null);

        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));
            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }

        $pagination = $this->get('knp_paginator')->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('syllabus/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/{id}/view", name="view")
     *
     * @param Request $request
     * @param CourseInfo $askAdvice
     * @param CourseInfoManager $adviceManager
     * @return JsonResponse|Response
     */
/*    public function viewAction(Request $request, AskAdvice $askAdvice, AskAdviceManager $adviceManager)
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($askAdvice->getCourseInfo()->getCourse()->getId());
        $form = $this->createForm(AskAdviceType::class, $askAdvice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adviceManager->update($askAdvice);
            return $this->redirectToRoute('app_admin.ask_advice_index');
        }

        return $this->render('ask_advice/view.html.twig', array(
            'askAdvice' => $askAdvice,
            'course' => $course,
            'form' => $form->createView(),
        ));
    }*/
}