<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseTutoringResource;
use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TutoringResourceControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class TutoringResourceControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @dataProvider editTutoringResourceSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditTutoringResourceSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $tutoringResource = new CourseTutoringResource();
        $tutoringResource->setCourseInfo($course);

        $em->persist($tutoringResource);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_RESOURCE_EDIT, ['id' => $tutoringResource->getId()])
        );

        $data['_token'] = $this->getCsrfToken('create_edit_tutoring_resources');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_RESOURCE_EDIT, ['id' => $tutoringResource->getId()]),
            ['course_tutoring_resources' => $data]
        );

        /** @var CourseTutoringResource $updatedCourseTutoringResource */
        $updatedCourseTutoringResource = $em->getRepository(CourseTutoringResource::class)->find($tutoringResource->getId());

        $this->assertCheckEntityProps($updatedCourseTutoringResource, $data);
    }

    /**
     * @return array
     */
    public function editTutoringResourceSuccessfulProvider(): array
    {
        return [
            [['description' => 'CourseTutoringResourceTest']],
            [['description' => null]]
        ];
    }

    /**
     * @dataProvider editTutoringResourceCsrfNotValidProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditTutoringResourceCsrfNotValid(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $tutoringResource = new CourseTutoringResource();
        $tutoringResource->setCourseInfo($course);

        $em->persist($tutoringResource);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_RESOURCE_EDIT, ['id' => $tutoringResource->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_RESOURCE_EDIT, ['id' => $tutoringResource->getId()]),
            ['course_tutoring_resources' => $data]
        );

        /** @var CourseTutoringResource $updatedCourseTutoringResource */
        $updatedCourseTutoringResource = $em->getRepository(CourseTutoringResource::class)->find($tutoringResource->getId());

        $this->assertCheckNotSameEntityProps($updatedCourseTutoringResource, $data);
    }

    /**
     * @return array
     */
    public function editTutoringResourceCsrfNotValidProvider(): array
    {
        return [
            [['description' => 'CourseTutoringResourceTest']],
            [['description' => null]]
        ];
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteTutoringResourceSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $tutoringResource = new CourseTutoringResource();
        $tutoringResource->setCourseInfo($course);

        $em->persist($tutoringResource);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_RESOURCE_DELETE, ['id' => $tutoringResource->getId()])
        );

        $tutoringResourceId = $tutoringResource->getId();
        $token = $this->getCsrfToken('delete_tutoring_resources');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_RESOURCE_DELETE, ['id' => $tutoringResource->getId()]),
            ['remove_course_tutoring_resources' => [
                '_token' => $token
            ]]
        );

        $this->assertNull($em->getRepository(CourseTutoringResource::class)->find($tutoringResourceId));
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteTutoringResourceWrongCsrfToken()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $tutoringResource = new CourseTutoringResource();
        $tutoringResource->setCourseInfo($course);

        $em->persist($tutoringResource);
        $em->flush();

        $token = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_RESOURCE_DELETE, ['id' => $tutoringResource->getId()]),
            ['remove_course_tutoring_resources' => [
                '_token' => $token
            ]]
        );

        /** @var CourseTutoringResource $checkTutoringResource */
        $checkTutoringResource = $em->getRepository(CourseTutoringResource::class)->find($tutoringResource->getId());

        $this->assertInstanceOf(CourseTutoringResource::class, $checkTutoringResource);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}