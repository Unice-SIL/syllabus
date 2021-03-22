<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CoursePrerequisite;
use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class PrerequisiteControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @dataProvider editCoursePrerequisiteSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditCoursePrerequisiteSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $coursePrerequisite = new CoursePrerequisite();
        $coursePrerequisite->setCourseInfo($course);

        $em->persist($coursePrerequisite);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_EDIT, ['id' => $coursePrerequisite->getId()])
        );

        $data['_token'] = $this->getCsrfToken('create_edit_prerequisite');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_EDIT, ['id' => $coursePrerequisite->getId()]),
            ['course_prerequisite' => $data]
        );

        /** @var CoursePrerequisite $updatedCoursePrerequisite */
        $updatedCoursePrerequisite = $em->getRepository(CoursePrerequisite::class)->find($coursePrerequisite->getId());

        $this->assertCheckEntityProps($updatedCoursePrerequisite, $data);
    }

    /**
     * @return array
     */
    public function editCoursePrerequisiteSuccessfulProvider(): array
    {
        return [
            [['description' => 'CoursePrerequisiteTest']],
            [['description' => null]]
        ];
    }

    /**
     * @dataProvider editCoursePrerequisiteCsrfNotValidProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditCoursePrerequisiteCsrfNotValid(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $coursePrerequisite = new CoursePrerequisite();
        $coursePrerequisite->setCourseInfo($course);

        $em->persist($coursePrerequisite);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_EDIT, ['id' => $coursePrerequisite->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_EDIT, ['id' => $coursePrerequisite->getId()]),
            ['course_prerequisite' => $data]
        );
        /** @var CoursePrerequisite $updatedCoursePrerequisite */
        $updatedCoursePrerequisite = $em->getRepository(CoursePrerequisite::class)->find($coursePrerequisite->getId());

        $this->assertCheckNotSameEntityProps($updatedCoursePrerequisite, $data);
    }

    /**
     * @return array
     */
    public function editCoursePrerequisiteCsrfNotValidProvider(): array
    {
        return [
            [['description' => 'CoursePrerequisiteTest']],
            [['description' => null]]
        ];
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteCoursePrerequisiteSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $coursePrerequisite = new CoursePrerequisite();
        $coursePrerequisite->setCourseInfo($course);

        $em->persist($coursePrerequisite);
        $em->flush();

        $coursePrerequisiteId = $coursePrerequisite->getId();
        $token = $this->getCsrfToken('delete_prerequisite');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_DELETE, ['id' => $coursePrerequisite->getId()]),
            ['remove_course_prerequisite' => [
                '_token' => $token
            ]]
        );

        $this->assertNull($em->getRepository(CoursePrerequisite::class)->find($coursePrerequisiteId));
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteCoursePrerequisiteWrongCsrfToken()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $coursePrerequisite = new CoursePrerequisite();
        $coursePrerequisite->setCourseInfo($course);

        $em->persist($coursePrerequisite);
        $em->flush();

        $token = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_DELETE, ['id' => $coursePrerequisite->getId()]),
            ['remove_course_prerequisite' => [
                '_token' => $token
            ]]
        );

        /** @var CoursePrerequisite $checkCoursePrerequisite */
        $checkCoursePrerequisite = $em->getRepository(CoursePrerequisite::class)->find($coursePrerequisite->getId());

        $this->assertInstanceOf(CoursePrerequisite::class, $checkCoursePrerequisite);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}