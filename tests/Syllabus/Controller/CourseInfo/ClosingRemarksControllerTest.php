<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Exception\CourseNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebTestCase;

/**
 * Class ClosingRemarksControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class ClosingRemarksControllerTest extends WebTestCase
{
    /**
     * @throws CourseNotFoundException
     */
    public function testClosingRemarksUserNotAuthenticated()
    {
        $course = $this->getCourse(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_INDEX, ['id' => $course->getId()]));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testClosingRemarksRedirectWithAdminPermission()
    {
        $this->login();
        $course = $this->getCourse(self::COURSE_NOT_ALLOWED_CODE, self::COURSE_NOT_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_INDEX, ['id' => $course->getId()]));
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testClosingRemarksRedirectWithPermission()
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_USER'])
            ->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login($user);
        $course = $this->getCourse(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_INDEX, ['id' => $course->getId()]));
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testClosingRemarksWithoutPermission()
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_USER'])
            ->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login($user);
        $course = $this->getCourse(self::COURSE_NOT_ALLOWED_CODE, self::COURSE_NOT_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_INDEX, ['id' => $course->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}