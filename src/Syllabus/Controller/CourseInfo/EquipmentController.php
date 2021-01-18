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
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class EquipmentController
 * @package AppBundle\Controller\CourseInfo
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
     * @return JsonResponse
     */
    public function editDescriptionResourceEquipmentAction(CourseResourceEquipment $resourceEquipment,
                                                           Request $request, CourseResourceEquipmentManager $courseResourceEquipmentManager)
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

        $render = $this->get('twig')->render('course_info/equipment/form/resource_equipment_edit.html.twig', [
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
     * @param TranslatorInterface $translator
     * @param Request $request
     * @param CourseResourceEquipmentManager $courseResourceEquipmentManager
     * @return JsonResponse
     */
    public function removeResourceEquipmentAction(CourseResourceEquipment $resourceEquipment, TranslatorInterface $translator,
                                                  Request $request, CourseResourceEquipmentManager $courseResourceEquipmentManager)
    {
        if (!$resourceEquipment) {
            return $this->json([
                'status' => false,
                'content' => $translator->trans('app.controller.error.empty_equipment')
            ]);
        };

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

        $render = $this->get('twig')->render('course_info/equipment/form/remove_resource_equipment.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}