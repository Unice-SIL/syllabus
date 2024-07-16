<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CourseResourceEquipment;
use App\Syllabus\Form\CourseInfo\Equipment\RemoveResourceEquipmentType;
use App\Syllabus\Form\CourseInfo\Equipment\ResourceEquipmentEditType;
use App\Syllabus\Manager\CourseResourceEquipmentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class EquipmentController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Route("/course-info/equipment/{id}", name="app.course_info.equipment.")
 * @Security("is_granted('WRITE', resourceEquipment)")
 */
class EquipmentController extends AbstractController
{
    /**
     * @Route("/edit", name="edit"))
     *
     * @param CourseResourceEquipment $resourceEquipment
     * @param Request $request
     * @param CourseResourceEquipmentManager $courseResourceEquipmentManager
     * @param Environment $twig
     * @return JsonResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function editDescriptionResourceEquipmentAction(
        CourseResourceEquipment $resourceEquipment,
        Request $request,
        CourseResourceEquipmentManager $courseResourceEquipmentManager,
        Environment $twig,
    ): JsonResponse
    {
        $form = $this->createForm(ResourceEquipmentEditType::class, $resourceEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseResourceEquipmentManager->update($resourceEquipment);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $twig->render('course_info/equipment/form/resource_equipment_edit.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/delete", name="delete"))
     *
     * @param CourseResourceEquipment $resourceEquipment
     * @param Environment $twig
     * @param Request $request
     * @param CourseResourceEquipmentManager $courseResourceEquipmentManager
     * @return JsonResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function removeResourceEquipmentAction(CourseResourceEquipment $resourceEquipment, Environment $twig,
                                                  Request $request, CourseResourceEquipmentManager $courseResourceEquipmentManager): JsonResponse
    {
        $form = $this->createForm(RemoveResourceEquipmentType::class, $resourceEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $courseResourceEquipmentManager->delete($resourceEquipment);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $twig->render('course_info/equipment/form/remove_resource_equipment.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}