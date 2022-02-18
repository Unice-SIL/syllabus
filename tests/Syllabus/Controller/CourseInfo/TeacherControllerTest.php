<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseTeacher;
use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TeacherControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class TeacherControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @dataProvider editCourseTeacherSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditCourseTeacherSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();
        $courseTeacher = new CourseTeacher();

        $courseTeacher->setCourseInfo($course);

        $em->persist($courseTeacher);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_EDIT, ['id' => $courseTeacher->getId()])
        );

        $data['_token'] = $this->getCsrfToken('create_edit_teacher');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_EDIT, ['id' => $courseTeacher->getId()]),
            ['edit_teacher' => $data]
        );

        /** @var CourseTeacher $updatedCourseTeacher */
        $updatedCourseTeacher = $em->getRepository(CourseTeacher::class)->find($courseTeacher->getId());

        $this->assertCheckEntityProps($updatedCourseTeacher, $data);
    }

    /**
     * @return array
     */
    public function editCourseTeacherSuccessfulProvider(): array
    {
        return [
            [['emailVisibility' => true, 'manager' => true]]
        ];
    }

    /**
     * @dataProvider editCourseTeacherCsrfNotValidProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditCourseTeacherCsrfNotValid(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();
        $courseTeacher = new CourseTeacher();

        $courseTeacher->setCourseInfo($course);

        $em->persist($courseTeacher);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_EDIT, ['id' => $courseTeacher->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_EDIT, ['id' => $courseTeacher->getId()]),
            ['edit_teacher' => $data]
        );

        /** @var CourseTeacher $updatedCourseTeacher */
        $updatedCourseTeacher = $em->getRepository(CourseTeacher::class)->find($courseTeacher->getId());

        $this->assertCheckNotSameEntityProps($updatedCourseTeacher, $data);
    }

    /**
     * @return array
     */
    public function editCourseTeacherCsrfNotValidProvider(): array
    {
        return [
            [['emailVisibility' => true, 'manager' => true]]
        ];
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteCourseTeacherSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $courseTeacher = new CourseTeacher();
        $courseTeacher->setCourseInfo($course);

        $em->persist($courseTeacher);
        $em->flush();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_DELETE, ['id' => $courseTeacher->getId()]),
          );

        $courseTeacherId = $courseTeacher->getId();
        $token = $this->getCsrfToken('delete_teacher');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_DELETE, ['id' => $courseTeacher->getId()]),
            ['remove_teacher' => [
                '_token' => $token
            ]]
        );

        $this->assertNull($em->getRepository(CourseTeacher::class)->find($courseTeacherId));
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteCourseTeacherWrongCsrfToken()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $courseTeacher = new CourseTeacher();
        $courseTeacher->setCourseInfo($course);

        $em->persist($courseTeacher);
        $em->flush();

        $token = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TEACHER_DELETE, ['id' => $courseTeacher->getId()]),
            ['remove_teacher' => [
                '_token' => $token
            ]]
        );

        /** @var CourseTeacher $checkCourseTeacher */
        $checkCourseTeacher = $em->getRepository(CourseTeacher::class)->find($courseTeacher->getId());

        $this->assertInstanceOf(CourseTeacher::class, $checkCourseTeacher);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}