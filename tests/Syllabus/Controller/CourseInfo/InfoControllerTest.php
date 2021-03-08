<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Exception\CourseNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InfoControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class InfoControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testInfoUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_INFO_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testInfoRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_INFO_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testInfoRedirectWithPermission()
    {
        $this->tryRedirectWithPermission(self::ROUTE_APP_INFO_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testInfoWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_INFO_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}