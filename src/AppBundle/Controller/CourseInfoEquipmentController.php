<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseResourceEquipment;
use AppBundle\Entity\Equipment;
use AppBundle\Form\CourseInfo\Equipment\RemoveResourceEquipmentType;
use AppBundle\Form\CourseInfo\Equipment\ResourceEquipmentEditType;
use AppBundle\Form\CourseInfo\Equipment\ResourceEquipmentType;
use AppBundle\Form\CourseInfo\Equipment\Resourcetype;
use AppBundle\Manager\CourseInfoManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseInfoEquipmentController
 * @package AppBundle\Controller
 *
 * @Route("/course/{id}/equipment", name="course_equipment_")
 * @Security("is_granted('WRITE', courseInfo)")
 *
 */
class CourseInfoEquipmentController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param $id
     * @return Response
     */
    public function indexAction(CourseInfo $courseInfo)
    {
        return $this->render('course_info/equipment/equipment.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/equipment/view", name="equipment_view"))
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function equipmentViewAction(CourseInfo $courseInfo)
    {
        $em = $this->getDoctrine()->getManager();
        $equipments = $em->getRepository(Equipment::class)->findAll();

        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas"
            ]);
        }

        $render = $this->get('twig')->render('course_info/equipment/view/equipment.html.twig', [
            'courseInfo' => $courseInfo,
            'equipments' => $equipments
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/add/{idEquipment}", name="equipment_add"))
     *
     * @param CourseInfo $courseInfo
     * @param Equipment $equipment
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws \Exception
     * @ParamConverter("equipment", options={"mapping": {"idEquipment": "id"}})
     */
    public function addEquipmentAction(CourseInfo $courseInfo, Equipment $equipment, Request $request, CourseInfoManager $manager)
    {
        if (!$equipment) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : le matériel n'existe pas."
            ]);
        };

        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $courseResourceEquipment = new CourseResourceEquipment();
        $courseResourceEquipment->setCourseInfo($courseInfo)->setEquipment($equipment);

        $form = $this->createForm(ResourceEquipmentType::class, $courseResourceEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseResourceEquipment = $form->getData();
            $courseInfo->addCourseResourceEquipment($courseResourceEquipment);
            $manager->update($courseInfo);

            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/equipment/form/equipment.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/edit/{resourceEquipementId}", name="equipment_edit"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseResourceEquipment $resourceEquipment
     * @param Request $request
     * @return JsonResponse
     * @ParamConverter("resourceEquipment", options={"mapping": {"resourceEquipementId": "id"}})
     */
    public function editDescriptionResourceEquipmentAction(CourseInfo $courseInfo, CourseResourceEquipment $resourceEquipment, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : le cours n'existe pas."
            ]);
        }

        $form = $this->createForm(ResourceEquipmentEditType::class, $resourceEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseResourceEquipment = $form->getData();
            $em->persist($courseResourceEquipment);
            $em->flush();
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
     * @Route("/remove/{idResourceEquipment}", name="equipment_remove"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseResourceEquipment $resourceEquipment
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws \Exception
     * @ParamConverter("resourceEquipment", options={"mapping": {"idResourceEquipment": "id"}})
     */
    public function removeResourceEquipmentAction(CourseInfo $courseInfo, CourseResourceEquipment $resourceEquipment, Request $request, CourseInfoManager $manager)
    {
        if (!$resourceEquipment) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : le matériel n'existe pas."
            ]);
        };

        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : le cours n'existe pas."
            ]);
        }

        $form = $this->createForm(RemoveResourceEquipmentType::class, $resourceEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $resourceEquipment = $form->getData();
            $courseInfo->removeCourseResourceEquipment($resourceEquipment);
            $manager->update($courseInfo);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/equipment/form/remove_resource_equipment.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/teaching/view", name="resource_view"))
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function resourceViewAction(CourseInfo $courseInfo)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $render = $this->get('twig')->render('course_info/equipment/view/resource.html.twig', [
            'courseInfo' => $courseInfo
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/teaching/form", name="resource_form"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return Response
     * @throws \Exception
     */
    public function resourceFormAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $form = $this->createForm(Resourcetype::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($courseInfo);
            $render = $this->get('twig')->render('course_info/equipment/view/resource.html.twig', [
                'courseInfo' => $courseInfo
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }

        $render = $this->get('twig')->render('course_info/equipment/form/resource.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}