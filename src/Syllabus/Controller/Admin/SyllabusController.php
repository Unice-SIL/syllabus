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
 * @Security("is_granted('ROLE_ADMIN_COURSE')")
 */
#[Route(path: 'syllabus', name: 'app.admin.syllabus.')]
class SyllabusController extends AbstractController
{

    /**
     * @Security("is_granted('ROLE_ADMIN_COURSE_LIST')")
     *
     */
    #[Route(path: '/list/{isExport}', name: 'index', methods: ['GET'])]
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