<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseResourceEquipment;
use AppBundle\Form\CourseInfo\Equipment\RemoveResourceEquipmentType;
use AppBundle\Form\CourseInfo\Equipment\ResourceEquipmentEditType;
use AppBundle\Manager\CourseResourceEquipmentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param CourseInfo $courseInfo
     * @param CourseResourceEquipment $resourceEquipment
     * @param Request $request
     * @param CourseResourceEquipmentManager $courseResourceEquipmentManager
     * @return JsonResponse
     */
    public function removeResourceEquipmentAction(CourseResourceEquipment $resourceEquipment,
                                                  Request $request, CourseResourceEquipmentManager $courseResourceEquipmentManager)
    {
        if (!$resourceEquipment) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : le matériel n'existe pas."
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