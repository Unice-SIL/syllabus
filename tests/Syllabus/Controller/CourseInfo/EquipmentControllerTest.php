<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CourseResourceEquipment;
use App\Syllabus\Entity\Equipment;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\EquipmentNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EquipmentControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class EquipmentControllerTest extends AbstractCourseInfoControllerTest
{

    /** @var CourseInfo $course */
    private $course;

    public function setUp(): void
    {
        $this->course = $this->getCourseInfo(CourseFixture::COURSE_1);
    }

    /**
     * @dataProvider editResourceEquipmentSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     * @throws EquipmentNotFoundException
     */
    public function testEditResourceEquipmentSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourseInfo();
        $equipment = $this->getEquipment();
        $resourceEquipment = new CourseResourceEquipment();

        $resourceEquipment->setCourseInfo($course)
            ->setEquipment($equipment);

        $em->persist($resourceEquipment);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_EQUIPMENT_EDIT, ['id' => $resourceEquipment->getId()])
        );

        $data['_token'] = $this->getCsrfToken('create_edit_equipment');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_EQUIPMENT_EDIT, ['id' => $resourceEquipment->getId()]),
            ['resource_equipment_edit' => $data]
        );

        /** @var CourseResourceEquipment $updatedResourceEquipment */
        $updatedResourceEquipment = $em->getRepository(CourseResourceEquipment::class)->find($resourceEquipment->getId());

        $this->assertCheckEntityProps($updatedResourceEquipment, $data);
    }

    /**
     * @return array
     */
    public function editResourceEquipmentSuccessfulProvider(): array
    {
        return [
            [['description' => 'EquipmentTest']],
            [['description' => null]]
        ];
    }

    /**
     * @dataProvider editResourceEquipmentCsrfNotValidProvider
     * @param array $data
     * @throws CourseNotFoundException
     * @throws EquipmentNotFoundException
     */
    public function testEditResourceEquipmentCsrfNotValid(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourseInfo();
        $equipment = $this->getEquipment();

        $resourceEquipment = new CourseResourceEquipment();
        $resourceEquipment->setCourseInfo($course)
            ->setEquipment($equipment);

        $em->persist($resourceEquipment);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_EQUIPMENT_EDIT, ['id' => $resourceEquipment->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_EQUIPMENT_EDIT, ['id' => $resourceEquipment->getId()]),
            ['resource_equipment_edit' => $data]
        );

        /** @var CourseResourceEquipment $updatedResourceEquipment */
        $updatedResourceEquipment = $em->getRepository(CourseResourceEquipment::class)->find($resourceEquipment->getId());

        $this->assertCheckNotSameEntityProps($updatedResourceEquipment, $data);
    }

    /**
     * @return array
     */
    public function editResourceEquipmentCsrfNotValidProvider(): array
    {
        return [
            [['description' => 'EquipmentTest']]
        ];
    }

    /**
     * @throws CourseNotFoundException
     * @throws EquipmentNotFoundException
     */
    public function testDeleteResourceEquipmentSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();

        $equipment = $this->course->getCourseResourceEquipments()->first();
        $this->assertNotNull($equipment);

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_EQUIPMENT_DELETE, [
                    'id' => $equipment->getId()
                ]
            )
        );

        $token = $this->getCsrfToken('delete_equipment');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_EQUIPMENT_DELETE, ['id' => $equipment->getId()]),
            ['remove_resource_equipment' => [
                '_token' => $token
            ]]
        );
        $this->assertNull($em->getRepository(Equipment::class)->find($equipment));
    }

    /**
     * @throws CourseNotFoundException
     * @throws EquipmentNotFoundException
     */
    public function testDeleteResourceEquipmentWrongCsrfToken()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourseInfo();
        $equipment = $this->getEquipment();

        $resourceEquipment = new CourseResourceEquipment();
        $resourceEquipment->setCourseInfo($course)
            ->setEquipment($equipment);

        $em->persist($resourceEquipment);
        $em->flush();

        $token = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_EQUIPMENT_DELETE, ['id' => $resourceEquipment->getId()]),
            ['remove_resource_equipment' => [
                '_token' => $token
            ]]
        );

        /** @var Equipment $checkEquipment */
        $checkEquipment = $em->getRepository(Equipment::class)->find($equipment->getId());

        $this->assertInstanceOf(Equipment::class, $checkEquipment);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}