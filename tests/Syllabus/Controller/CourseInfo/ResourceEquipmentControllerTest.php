<?php

namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Equipment;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\EquipmentNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use App\Syllabus\Fixture\EquipmentFixture;
use App\Syllabus\Fixture\UserFixture;
use Symfony\Component\HttpFoundation\Response;

class ResourceEquipmentControllerTest extends AbstractCourseInfoControllerTest
{

    /** @var CourseInfo $course */
    private $course;

    public function setUp(): void
    {
        $this->course = $this->getCourseInfo(CourseFixture::COURSE_1);
    }

    public function testIndexUnauthorized()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_RESOURCE_EQUIPMENT_INDEX, ['id' => $this->course->getId()])
        );
        $this->assertRedirectToLogin();
    }

    /**
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testIndexForbidden()
    {
        $this->login(UserFixture::USER_2);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_RESOURCE_EQUIPMENT_INDEX, [
                'id' => $this->getCourseInfo(self::COURSE_NOT_ALLOWED_CODE)->getId()
            ])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testResourceEquipmentWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testResourceEquipmentRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_INDEX);
        $this->assertResponseIsSuccessful();
    }

    // action equipmentView
    /**
     * @throws CourseNotFoundException
     */
    public function testResourceEquipmentViewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_RESOURCE_EQUIPMENT_EQUIPMENT_VIEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws UserNotFoundException
     */
    public function testResourceEquipmentViewSuccessful()
    {
        $this->login();
        $this->client()->request('GET',
            $this->generateUrl(self::ROUTE_APP_RESOURCE_EQUIPMENT_EQUIPMENT_VIEW,
                [
                    'id' => $this->course->getId()
                ]
            )
        );
        $response = $this->client()->getResponse()->getContent();
        self::assertJson($response);
        self::assertEquals($this->course->getCourseResourceEquipments()->count(), 3);
    }

    // action resourceEdit
    /**
     * @throws CourseNotFoundException
     */
    public function testResourceEditUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_EDIT);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testResourceEditRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_EDIT);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testResourceEditWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_EDIT, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testResourceEditWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_EDIT);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @dataProvider editEquipmentResourceSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException|UserNotFoundException
     */
    public function testEditRessourceSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_EDIT, ['id' => $this->course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('resource');
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_EDIT, ['id' => $this->course->getId()]),
            ['resource' => $data]
        );

        /** @var CourseInfo $updatedRessource */
        $updatedRessource = $em->getRepository(CourseInfo::class)->findOneBy(['id' => $this->course->getId()]);

        $this->assertEquals($updatedRessource->getBibliographicResources(), $data['bibliographicResources']);
        // $this->assertEquals($updatedRessource->getEducationalResources(), $data['educationalResource']);
    }

    /**
     * @return array
     */
    public function editEquipmentResourceSuccessfulProvider(): array
    {
        return [
            [
                ['bibliographicResources' => 'Ressources bibliographiques'],
                ['educationalResource' => 'educational Resourcese']
            ]
            ,
            [
                ['bibliographicResources' => null],
                ['educationalResource' => 'educational Resourcese']
            ],
            [
                ['bibliographicResources' => null],
                ['educationalResource' => null]
            ],
            [
                ['bibliographicResources' => 'Ressources bibliographiques'],
                ['educationalResource' => null]
            ],
        ];
    }

    // resourceViewAction
    /**
     * @throws CourseNotFoundException
     */
    public function testResourceViewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_VIEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testResourceViewRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_VIEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testResourceViewtWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_VIEW, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testResourceViewWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_VIEW);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    //addEquipementAction
    public function testAddEquipmentForbidden()
    {
        $em = $this->getEntityManager();
        $this->login(UserFixture::USER_2);
        $equipments = $em->getRepository(Equipment::class)->findBy(['obsolete' => false], ['label' => 'ASC']);

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_ADD, [
                'id' => $this->getCourseInfo(self::COURSE_NOT_ALLOWED_CODE)->getId(),
                'idEquipment' => $equipments[0]->getId()
            ])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws UserNotFoundException|EquipmentNotFoundException
     */
    public function testAddEquipmentSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();

        $equipment = $this->getEquipment(EquipmentFixture::EQUIPMENT_3);

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_ADD, [
                    'id' => $this->course->getId(),
                    'idEquipment' => $equipment->getId()
                ]
            )
        );
        $token = $this->getCsrfToken('resource_equipment');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_RESOURCE_EQUIPMENT_RESOURCE_ADD,
                [
                    'id' => $this->course->getId(),
                    'idEquipment' => $equipment->getId()
                ]
            ),
            [
                'resource_equipment' => [
                    "description" => "myDescription",
                    "_token" => $token
                ]
            ]
        );
        $course = $em->getRepository(CourseInfo::class)->findOneBy(['id' => $this->course->getId()]);
        self::assertEquals($course->getCourseResourceEquipments()->count(), 4);

        $createdEquipment = $this->getEntityManager()->getRepository(Equipment::class)->findOneBy(['label' => $equipment->getLabel()]);
        $this->assertNotNull($createdEquipment);
    }
}