<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ObjectivesControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class ObjectivesControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_OBJECTIVES_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_OBJECTIVES_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesRedirectWithPermission()
    {
        $this->tryRedirectWithPermission(self::ROUTE_APP_OBJECTIVES_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_OBJECTIVES_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}