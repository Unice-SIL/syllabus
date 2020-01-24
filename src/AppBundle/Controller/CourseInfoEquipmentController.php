<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseResourceEquipment;
use AppBundle\Entity\Equipment;
use AppBundle\Form\CourseInfo\Equipment\RemoveResourceEquipmentType;
use AppBundle\Form\CourseInfo\Equipment\ResourceEquipmentEditType;
use AppBundle\Form\CourseInfo\Equipment\ResourceEquipmentType;
use AppBundle\Form\CourseInfo\Equipment\Resourcetype;
use AppBundle\Manager\CourseInfoManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use http\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseInfoEquipmentController extends Controller
{
    /**
     * @Route("/course/{id}/equipment", name="course_equipment")
     *
     * @param $id
     * @return Response
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        return $this->render('course_info/equipment/equipment.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/course/{id}/equipment/equipment/view", name="course_equipment_equipment_view"))
     *
     * @param $id
     * @return Response
     */
    public function equipmentViewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);
        $equipments = $em->getRepository(Equipment::class)->findAll();


        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Le cours {$id} n'existe pas."
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
     * @Route("/course/{idCourseInfo}/equipment/add/{idEquipment}", name="course_equipment_equipment_add"))
     *
     * @param $idCourseInfo
     * @param $idEquipment
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws \Exception
     */
    public function addEquipment($idCourseInfo, $idEquipment, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Equipment $equipment */
        $equipment = $em->getRepository(Equipment::class)->find($idEquipment);
        if (!$equipment) {
            return $this->json([
                'status' => false,
                'content' => "Le matériel {$idEquipment} n'existe pas."
            ]);
        };
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($idCourseInfo);
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Le cours {$idCourseInfo} n'existe pas."
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
     * @Route("/course/equipment/edit/{idResourceEquipment}", name="course_equipment_equipment_edit"))
     *
     * @param $idResourceEquipment
     * @param Request $request
     * @param EntityManager $manager
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editDescriptionResourceEquipment($idResourceEquipment, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseResourceEquipment $resourceEquipment */
        $resourceEquipment = $em->getRepository(CourseResourceEquipment::class)->find($idResourceEquipment);
        $form = $this->createForm(ResourceEquipmentEditType::class, $resourceEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseResourceEquipment = $form->getData();
            dump($courseResourceEquipment);
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
     * @Route("/course/{idCourseInfo}/equipment/remove/{idResourceEquipment}", name="course_equipment_equipment_remove"))
     *
     * @param $idCourseInfo
     * @param $idResourceEquipment
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws \Exception
     */
    public function removeResourceEquipment($idCourseInfo, $idResourceEquipment, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseResourceEquipment $resourceEquipment */
        $resourceEquipment = $em->getRepository(CourseResourceEquipment::class)->find($idResourceEquipment);
        if (!$resourceEquipment) {
            return $this->json([
                'status' => false,
                'content' => "Le matériel {$idResourceEquipment} n'existe pas."
            ]);
        };
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($idCourseInfo);
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Le cours {$idCourseInfo} n'existe pas."
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
     * @Route("/course/{id}/equipment/teaching/view", name="course_equipment_resource_view"))
     *
     * @param Request $request
     * @return Response
     */
    public function resourceViewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Le cours {$id} n'existe pas."
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
     * @Route("/course/{id}/equipment/teaching/form", name="course_equipment_resource_form"))
     *
     * @param $id
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return Response
     * @throws \Exception
     */
    public function resourceFormAction($id, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Le cours {$id} n'existe pas."
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