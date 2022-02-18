<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ClosingRemarksControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class ClosingRemarksControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testClosingRemarksUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_CLOSING_REMARKS_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testClosingRemarksRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_CLOSING_REMARKS_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testClosingRemarksWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_CLOSING_REMARKS_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testClosingRemarksWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_CLOSING_REMARKS_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}