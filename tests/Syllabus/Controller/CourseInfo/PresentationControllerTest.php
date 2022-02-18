<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PresentationControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class PresentationControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_PRESENTATION_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_PRESENTATION_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_PRESENTATION_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_PRESENTATION_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}