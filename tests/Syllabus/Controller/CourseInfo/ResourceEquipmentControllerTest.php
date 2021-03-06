<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Exception\CourseNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
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
    public function testResourceEquipmentRedirectWithPermission()
    {
        $this->tryRedirectWithPermission(self::ROUTE_APP_RESOURCE_EQUIPMENT_INDEX);
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