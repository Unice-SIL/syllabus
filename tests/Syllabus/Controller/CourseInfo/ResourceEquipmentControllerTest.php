<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ResourceEquipmentControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testResourceEquipmentUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_RESOURCE_EQUIPMENT_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testResourceEquipmentRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testResourceEquipmentWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testResourceEquipmentWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}