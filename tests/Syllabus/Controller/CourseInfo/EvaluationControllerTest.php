<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Exception\CourseNotFoundException;
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
    public function testEvaluationWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_EVALUATION_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testEvaluationSpecificationWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_EVALUATION_SPECIFICATION);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException

    public function testEvaluationWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_EVALUATION_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
    
    /**
     * @dataProvider editSpecificationsSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditSpecificationsSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_EVALUATION_SPECIFICATIONS_EDIT, ['id' => $course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('create_edit_specifications');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_EVALUATION_SPECIFICATIONS_EDIT, ['id' => $course->getId()]),
            ['specifications' => $data]
        );

        /** @var CourseInfo $updatedCourseInfo */
        $updatedCourseInfo = $em->getRepository(CourseInfo::class)->find($course->getId());

        $this->assertCheckEntityProps($updatedCourseInfo, $data);
    }

    /**
     * @return array
     */
    public function editSpecificationsSuccessfulProvider(): array
    {
        return [
            [['mccAdvice' => 'CourseInfoMccAdviceTest']]
        ];
    }

    /**
     * @dataProvider editSpecificationsCsrfNotValidProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditSpecificationsCsrfNotValid(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_EVALUATION_SPECIFICATIONS_EDIT, ['id' => $course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_EVALUATION_SPECIFICATIONS_EDIT, ['id' => $course->getId()]),
            ['specifications' => $data]
        );

        /** @var CourseInfo $updatedCourseInfo */
        $updatedCourseInfo = $em->getRepository(CourseInfo::class)->find($course->getId());

        $this->assertCheckNotSameEntityProps($updatedCourseInfo, $data);
    }

    /**
     * @return array
     */
    public function editSpecificationsCsrfNotValidProvider(): array
    {
        return [
            [['mccAdvice' => 'CourseInfoMccAdviceTest']]
        ];
    }

}