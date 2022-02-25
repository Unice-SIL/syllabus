<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CourseTeacher;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use App\Syllabus\Fixture\UserFixture;
use App\Syllabus\Fixture\YearFixture;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TeacherControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class TeacherControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @var CourseTeacher
     */
    private $courseTeacher;

    /**
     * @throws CourseNotFoundException
     */
    protected function setUp(): void
    {
        $this->courseTeacher = $this->getCourse(CourseFixture::COURSE_1, YearFixture::YEAR_2018)
            ->getCourseTeachers()->offsetGet(0);
    }

    public function testEditCourseTeacherUnauthorized()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_EDIT, ['id' => $this->courseTeacher->getId()])
        );
        $this->assertRedirectToLogin();
    }

    /**
     * @throws UserNotFoundException
     */
    public function testEditCourseTeacherForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_EDIT, ['id' => $this->courseTeacher->getId()])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws UserNotFoundException
     */
    public function testEditCourseTeacherSuccessful()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_EDIT, ['id' => $this->courseTeacher->getId()])
        );

        $this->assertResponseIsSuccessful();
        $data = [
            '_token' => $this->getCsrfToken('create_edit_teacher')
        ];
        if ($this->courseTeacher->isEmailVisibility() === false) {
            $data['emailVisibility'] = true;
        }
        if ($this->courseTeacher->isManager() === false) {
            $data['manager'] = true;
        }

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_EDIT, ['id' => $this->courseTeacher->getId()]),
            ['edit_teacher' => $data]
        );

        $data['emailVisibility'] = $data['emailVisibility'] ?? false;
        $data['manager'] = $data['manager'] ?? false;

        /** @var CourseTeacher $updatedCourseTeacher */
        $updatedCourseTeacher = $this->getEntityManager()->getRepository(CourseTeacher::class)->find($this->courseTeacher->getId());
        $this->assertResponseIsSuccessful();
        $this->assertCheckEntityProps($updatedCourseTeacher, $data);
    }

    /**
     * @throws UserNotFoundException
     */
    public function testEditCourseTeacherCsrfNotValid()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_EDIT, ['id' => $this->courseTeacher->getId()])
        );

        $this->assertResponseIsSuccessful();
        $data = [
            '_token' => 'invalidToken'
        ];
        if ($this->courseTeacher->isEmailVisibility() === false) {
            $data['emailVisibility'] = true;
        }
        if ($this->courseTeacher->isManager() === false) {
            $data['manager'] = true;
        }

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_EDIT, ['id' => $this->courseTeacher->getId()]),
            ['edit_teacher' => $data]
        );

        $data['emailVisibility'] = $data['emailVisibility'] ?? false;
        $data['manager'] = $data['manager'] ?? false;

        $this->assertResponseIsSuccessful();
        $this->getEntityManager()->clear();
        $updatedCourseTeacher = $this->getEntityManager()->getRepository(CourseTeacher::class)->find($this->courseTeacher->getId());
        $this->assertCheckNotSameEntityProps($updatedCourseTeacher, $data);
    }

    public function testDeleteCourseTeacherUnauthorized()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_DELETE, ['id' => $this->courseTeacher->getId()])
        );
        $this->assertRedirectToLogin();
    }

    /**
     * @throws UserNotFoundException
     */
    public function testDeleteCourseTeacherForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_DELETE, ['id' => $this->courseTeacher->getId()])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws UserNotFoundException
     */
    public function testDeleteCourseTeacherSuccessful()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_DELETE, ['id' => $this->courseTeacher->getId()])
        );

        $token = $this->getCsrfToken('delete_teacher');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_DELETE, ['id' => $this->courseTeacher->getId()]),
            ['remove_teacher' => [
                '_token' => $token
            ]]
        );
        $this->assertResponseIsSuccessful();
        $this->assertNull($this->getEntityManager()->getRepository(CourseTeacher::class)->find($this->courseTeacher->getId()));
    }

    /**
     * @throws UserNotFoundException
     */
    public function testDeleteCourseTeacherInvalidToken()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_DELETE, ['id' => $this->courseTeacher->getId()])
        );
        $this->assertResponseIsSuccessful();

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_DELETE, ['id' => $this->courseTeacher->getId()]),
            ['remove_teacher' => [
                '_token' => 'invalidToken'
            ]]
        );
        $this->assertResponseIsSuccessful();
        $this->assertInstanceOf(CourseTeacher::class, $this->getEntityManager()->getRepository(CourseTeacher::class)->find($this->courseTeacher->getId()));
    }
}