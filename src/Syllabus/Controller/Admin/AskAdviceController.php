<?php


namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Entity\AskAdvice;
use App\Syllabus\Entity\Course;
use App\Syllabus\Form\CourseInfo\dashboard\AskAdviceType;
use App\Syllabus\Manager\AskAdviceManager;
use App\Syllabus\Repository\Doctrine\CourseDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AskAdviceController
 * @package App\Syllabus\Controller
 */
#[Route(path: '/askAdvice', name: 'app.admin.ask_advice.')]
class AskAdviceController extends AbstractController
{
    /**
     * Lists all activity entities.
     */
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function indexAction(Request $request, AskAdviceManager $adviceManager, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $adviceManager->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('ask_advice/index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    
    #[Route(path: '/{id}/view', name: 'view')]
    public function viewAction(
        Request $request,
        AskAdvice $askAdvice,
        AskAdviceManager $adviceManager,
        CourseDoctrineRepository $courseDoctrineRepository
    ): JsonResponse|Response
    {
        $course = $courseDoctrineRepository->find($askAdvice->getCourseInfo()->getCourse()->getId());
        $form = $this->createForm(AskAdviceType::class, $askAdvice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adviceManager->update($askAdvice);
            return $this->redirectToRoute('app.admin.ask_advice.index');
        }

        return $this->render('ask_advice/view.html.twig', array(
            'askAdvice' => $askAdvice,
            'course' => $course,
            'form' => $form->createView(),
        ));
    }
}