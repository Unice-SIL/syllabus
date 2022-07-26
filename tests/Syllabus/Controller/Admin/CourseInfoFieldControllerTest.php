<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\CourseInfoField;
use App\Syllabus\Exception\CourseInfoFieldNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CourseInfoFieldControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CourseInfoFieldControllerTest extends AbstractAdminControllerTest
{
    public function testCourseInfoFieldListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_COURSE_INFO_FIELD_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCourseInfoFieldListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_INFO_FIELD_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseInfoFieldNotFoundException
     */
    public function testEditCourseInfoFieldUserNotAuthenticated()
    {
        $courseInfoField = $this->getCourseInfoField();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_COURSE_INFO_FIELD_EDIT, ['id' => $courseInfoField->getId()],
            Request::METHOD_POST
        );
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseInfoFieldNotFoundException
     */
    public function testEditCourseInfoFieldWithAdminPermission()
    {
        $courseInfoField = $this->getCourseInfoField();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_INFO_FIELD_EDIT, ['id' => $courseInfoField->getId()],
            Request::METHOD_POST
        );
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editCourseInfoFieldWithMissingRoleProvider
     * @param array $data
     * @throws CourseInfoFieldNotFoundException
     * @throws UserNotFoundException
     */
    public function testEditCourseInfoFieldWithMissingRole(array $data)
    {
        $courseInfoField = $this->getCourseInfoField();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request(Request::METHOD_POST, $this->generateUrl(self::ROUTE_ADMIN_COURSE_INFO_FIELD_EDIT, ['id' => $courseInfoField->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editCourseInfoFieldWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER']],
        ];
    }

    public function testEditCourseInfoFieldWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_INFO_FIELD_EDIT, ['id' => 'fakeId'], Request::METHOD_POST);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @return void
     * @throws CourseInfoFieldNotFoundException
     * @throws UserNotFoundException
     */
    public function testEditCourseInfoFieldSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();

        $courseInfoField = $this->getCourseInfoField();

        $courseInfoField->setAutomaticDuplication(false)
            ->setManuallyDuplication(false)
            ->setImport(false);
        $em->persist($courseInfoField);
        $em->flush();

        $this->client()->request(
            Request::METHOD_GET,
            $this->generateUrl(self::ROUTE_ADMIN_COURSE_INFO_FIELD_LIST)
        );

        $token = $this->getCsrfToken('appbundle_course_info_field');
        $data = [
            'manuallyDuplication' => true,
            'automaticDuplication' => true,
            'import' => true,
            '_token' => $token
        ];

        $this->client()->request(
            Request::METHOD_POST,
            $this->generateUrl(self::ROUTE_ADMIN_COURSE_INFO_FIELD_EDIT, ['id' => $courseInfoField->getId()]),
            ['appbundle_course_info_field' => $data]
        );

        /** @var CourseInfoField $updatedCourseInfoField */
        $updatedCourseInfoField = $em->getRepository(CourseInfoField::class)->find($courseInfoField->getId());

        $this->assertCheckEntityProps($updatedCourseInfoField, $data);
    }
}