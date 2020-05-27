<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Equipment;
use AppBundle\Form\CourseInfo\Equipment\ResourceEquipmentType;
use AppBundle\Form\CourseInfo\Equipment\Resourcetype;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CourseResourceEquipmentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class ResourceEquipmentController
 * @package AppBundle\Controller\CourseInfo
 *
 * @Route("/course-info/{id}/resource-equipment", name="app.course_info.resource_equipment.")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class ResourceEquipmentController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function indexAction(CourseInfo $courseInfo)
    {
        return $this->render('course_info/equipment/equipment.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/equipments", name="equipments"))
     *
     * @param CourseInfo $courseInfo
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function equipmentViewAction(CourseInfo $courseInfo, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $equipments = $em->getRepository(Equipment::class)->findBy([], ['label' => 'ASC']);

        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => $translator->trans('app.controller.error.empty_course')
            ]);
        }

        /*
        setlocale(LC_ALL, "fr_FR.utf8");
        usort($equipments, function ($a, $b) {
            return strcoll($a->getLabel(), $b->getLabel());
        });
        */

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
     * @Route("/equipment/add/{idEquipment}", name="equipment.add"))
     *
     * @param CourseInfo $courseInfo
     * @param Equipment $equipment
     * @param Request $request
     * @param CourseResourceEquipmentManager $courseResourceEquipmentManager
     * @param TranslatorInterface $translator
     * @return JsonResponse
     * @ParamConverter("equipment", options={"mapping": {"idEquipment": "id"}})
     */
    public function addEquipmentAction(CourseInfo $courseInfo, Equipment $equipment, Request $request,
                                       CourseResourceEquipmentManager $courseResourceEquipmentManager, TranslatorInterface $translator)
    {
        if (!$equipment) {
            return $this->json([
                'status' => false,
                'content' => $translator->trans('app.controller.error.empty_equipment')
            ]);
        };

        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => $translator->trans('app.controller.error.empty_course')
            ]);
        }

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

        $render = $this->get('twig')->render('course_info/equipment/form/equipment.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/resources", name="resources"))
     *
     * @param CourseInfo $courseInfo
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function resourceViewAction(CourseInfo $courseInfo, TranslatorInterface $translator)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => $translator->trans('app.controller.error.empty_course')
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
     * @Route("/resource/edit", name="resource.edit"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function resourceEditAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager, TranslatorInterface $translator)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => $translator->trans('app.controller.error.empty_course')
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