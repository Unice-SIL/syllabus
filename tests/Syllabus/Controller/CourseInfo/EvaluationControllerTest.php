<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Exception\CourseNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EvaluationControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class EvaluationControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testEvaluationUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_EVALUATION_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testEvaluationRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_EVALUATION_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testEvaluationRedirectWithPermission()
    {
        $this->tryRedirectWithPermission(self::ROUTE_APP_EVALUATION_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testEvaluationWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_EVALUATION_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}