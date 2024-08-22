<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Equipment;
use App\Syllabus\Form\CourseInfo\Equipment\ResourceEquipmentType;
use App\Syllabus\Form\CourseInfo\Equipment\Resourcetype;
use App\Syllabus\Manager\CourseInfoManager;
use App\Syllabus\Manager\CourseResourceEquipmentManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ResourceEquipmentController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Security("is_granted('WRITE', courseInfo)")
 */
#[Route(path: '/course-info/{id}/resource-equipment', name: 'app.course_info.resource_equipment.')]
class ResourceEquipmentController extends AbstractController
{
    
    #[Route(path: '/', name: 'index')]
    public function indexAction(CourseInfo $courseInfo): Response
    {
        return $this->render('course_info/equipment/equipment.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/equipments', name: 'equipments')]
    public function equipmentViewAction(CourseInfo $courseInfo, Environment $twig, EntityManagerInterface $em): Response
    {
        $equipments = $em->getRepository(Equipment::class)->findBy(['obsolete' => false], ['label' => 'ASC']);

        $render = $twig->render('course_info/equipment/view/equipment.html.twig', [
            'courseInfo' => $courseInfo,
            'equipments' => $equipments
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     *
     * @param CourseInfo $courseInfo
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @ParamConverter("equipment", options={"mapping": {"idEquipment": "id"}})
     */
    #[Route(path: '/equipment/add/{idEquipment}', name: 'equipment.add')] // @ParamConverter("equipment", options={"mapping": {"idEquipment": "id"}})
    public function addEquipmentAction(CourseInfo                     $courseInfo,
                                       Equipment $equipment,
                                       Request $request,
                                       CourseResourceEquipmentManager $courseResourceEquipmentManager,
                                       Environment $twig
    ): JsonResponse
    {
        $courseResourceEquipment = $courseResourceEquipmentManager->new($courseInfo, $equipment);

        $form = $this->createForm(ResourceEquipmentType::class, $courseResourceEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseResourceEquipmentManager->create($courseResourceEquipment);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $twig->render('course_info/equipment/form/equipment.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/resources', name: 'resources')]
    public function resourceViewAction(CourseInfo $courseInfo, Environment $twig): Response
    {
        $render = $twig->render('course_info/equipment/view/resource.html.twig', [
            'courseInfo' => $courseInfo
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/resource/edit', name: 'resource.edit')]
    public function resourceEditAction(CourseInfo        $courseInfo,
                                       Request           $request,
                                       CourseInfoManager $manager,
                                       Environment       $twig): Response
    {
        $form = $this->createForm(Resourcetype::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($courseInfo);
            $render = $twig->render('course_info/equipment/view/resource.html.twig', [
                'courseInfo' => $courseInfo
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }

        $render = $twig->render('course_info/equipment/form/resource.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}