<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Constant\UserRole;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\StructureNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use App\Syllabus\Exception\YearNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CourseInfoControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CourseInfoControllerTest extends AbstractAdminControllerTest
{
    public function testCourseInfoPublishedUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(
            self::ROUTE_ADMIN_COURSE_INFO_PUBLISHED,
            [
                'year' => $this->getCourseInfo()->getYear()->getId()
            ]
        );
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCourseInfoPublishedWithAdminPermission()
    {
        $this->tryWithAdminPermission(
            self::ROUTE_ADMIN_COURSE_INFO_PUBLISHED,
            [
                'year' => $this->getCourseInfo()->getYear()->getId()
            ]
        );
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws UserNotFoundException
     * @throws CourseNotFoundException
     */
    public function testCourseInfoPublishedWithMissingRole()
    {
        $this->getUser()->setRoles([UserRole::ROLE_USER])->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(
            self::ROUTE_ADMIN_COURSE_INFO_PUBLISHED,
            [
                'year' => $this->getCourseInfo()->getYear()->getId()
            ]
        ));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testCourseInfoPublishedWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_INFO_PUBLISHED, ['year' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testCourseInfoBeingFilledUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(
            self::ROUTE_ADMIN_COURSE_INFO_BEING_FILLED,
            [
                'year' => $this->getCourseInfo()->getYear()->getId()
            ]
        );
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCourseInfoBeingFilledWithAdminPermission()
    {
        $this->tryWithAdminPermission(
            self::ROUTE_ADMIN_COURSE_INFO_BEING_FILLED,
            [
                'year' => $this->getCourseInfo()->getYear()->getId()
            ]
        );
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws UserNotFoundException
     * @throws CourseNotFoundException
     */
    public function testCourseInfoBeingFilledWithMissingRole()
    {
        $this->getUser()->setRoles([UserRole::ROLE_USER])->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(
            self::ROUTE_ADMIN_COURSE_INFO_BEING_FILLED,
            [
                'year' => $this->getCourseInfo()->getYear()->getId()
            ]
        ));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testCourseInfoBeingFilledWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_INFO_BEING_FILLED, ['year' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testEditCourseInfoUserNotAuthenticated()
    {
        $courseInfo = $this->getCourseInfo();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_COURSE_INFO_EDIT, ['id' => $courseInfo->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testEditCourseInfoWithAdminPermission()
    {
        $courseInfo = $this->getCourseInfo();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_INFO_EDIT, ['id' => $courseInfo->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testEditCourseInfoWithMissingRole()
    {
        $courseInfo = $this->getCourseInfo();
        $this->getUser()->setRoles([UserRole::ROLE_USER])->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_INFO_EDIT, ['id' => $courseInfo->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testEditCourseInfoWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_INFO_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editCourseInfoSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testEditCourseInfoSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $courseInfo = $this->getCourseInfo();

        $em->persist($courseInfo);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_COURSE_INFO_EDIT, ['id' => $courseInfo->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'course_info',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var CourseInfo $updatedCourseInfo */
        $updatedCourseInfo = $em->getRepository(CourseInfo::class)->find($courseInfo->getId());

        $this->assertEquals($updatedCourseInfo->getTitle(), $data['title']);
        $this->assertEquals($updatedCourseInfo->getYear()->getId(), $data['year']);
        $this->assertEquals($updatedCourseInfo->getStructure()->getId(), $data['structure']);
    }

    /**
     * @return \array[][]
     * @throws StructureNotFoundException
     * @throws YearNotFoundException
     */
    public function editCourseInfoSuccessfulProvider(): array
    {
        return [
            [
                [
                    'title' => 'CourseInfoTest',
                    'year' => $this->getYear()->getId(),
                    'structure' => $this->getStructure()->getId()
                ]
            ]
        ];
    }
}