<?php


namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Export\SyllabusExport;
use App\Syllabus\Form\Filter\SyllabusFilterType;
use App\Syllabus\Repository\Doctrine\CourseInfoDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class SyllabusController
 * @package App\Syllabus\Controller\Admin
 *
 * @Route("syllabus", name="app.admin.syllabus.")
 * @Security("is_granted('ROLE_ADMIN_COURSE')")
 */
class SyllabusController extends AbstractController
{

    /**
     * @Route("/list/{isExport}", name="index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_COURSE_LIST')")
     *
     * @param Request $request
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param SyllabusExport $syllabusExport
     * @param PaginatorInterface $paginator
     * @param bool $isExport
     * @return Response
     */
    public function indexAction(
        Request $request,
        CourseInfoDoctrineRepository $courseInfoDoctrineRepository,
        FilterBuilderUpdaterInterface $filterBuilderUpdater,
        SyllabusExport $syllabusExport,
        PaginatorInterface $paginator,
        bool $isExport = false
    ): Response
    {
        $qb = $courseInfoDoctrineRepository->getIndexQueryBuilder();
        $form = $this->createForm(SyllabusFilterType::class, null);

        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));
            $filterBuilderUpdater->addFilterConditions($form, $qb);
        }


        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        if ($isExport)
        {
            set_time_limit(0);
            return $syllabusExport->export('Liste_Syllabus', $qb->getQuery()->getResult());
        }

        return $this->render('syllabus/index.html.twig', array(
            'pagination' => $pagination,
            'form' => $form->createView(),
        ));
    }
}