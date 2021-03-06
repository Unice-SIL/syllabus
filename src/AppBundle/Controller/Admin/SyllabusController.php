<?php


namespace AppBundle\Controller\Admin;


use AppBundle\Entity\CourseInfo;
use AppBundle\Export\SyllabusExport;
use AppBundle\Form\Filter\SyllabusFilterType;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class SyllabusController
 * @package AppBundle\Controller\Admin
 *
 * @Route("syllabus", name="app.admin.syllabus.")
 * @Security("is_granted('ROLE_ADMIN_COURSE')")
 */
class SyllabusController extends Controller
{

    /**
     * @Route("/list/{isExport}", name="index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_COURSE_LIST')")
     *
     * @param Request $request
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param SyllabusExport $syllabusExport
     * @param bool $isExport
     * @return Response
     */
    public function indexAction(
        Request $request,
        CourseInfoDoctrineRepository $courseInfoDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater,
        SyllabusExport $syllabusExport,
        bool $isExport = false
    )
    {
        $qb = $this->getDoctrine()->getManager()->getRepository(CourseInfo::class)->createQueryBuilder('ci');
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

        if ($isExport)
        {
            return $syllabusExport->export('Liste_Syllabus', $qb->getQuery()->getResult());
        }

        return $this->render('syllabus/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }
}