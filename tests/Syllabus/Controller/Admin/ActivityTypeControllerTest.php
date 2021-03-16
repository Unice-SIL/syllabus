<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\ActivityType;
use App\Syllabus\Exception\ActivityModeNotFoundException;
use App\Syllabus\Exception\ActivityTypeNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ActivityTypeControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ActivityTypeControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Activity Type List
     */

    public function testActivityTypeUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_TYPE_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityTypeWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_TYPE_LIST);
        $this->assertResponseIsSuccessful();
    }


    /**
     * @dataProvider activityTypeWithMissingRoleProvider
     * @param array $data
     */
    public function testActivityTypeWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_TYPE_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function activityTypeWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYTYPE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYTYPE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYTYPE', 'ROLE_ADMIN_ACTIVITYTYPE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYTYPE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYTYPE_LIST']],
        ];
    }

    /*
     *  New Activity Type
     */

    public function testActivityTypeNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_TYPE_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityTypeNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_TYPE_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider activityTypeNewWithMissingRoleProvider
     * @param array $data
     */
    public function testActivityTypeNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_TYPE_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function activityTypeNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYTYPE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYTYPE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYTYPE', 'ROLE_ADMIN_ACTIVITYTYPE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYTYPE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYTYPE_CREATE']],
        ];
    }


    /**
     * @dataProvider newActivityTypeSuccessfulProvider
     * @param array $data
     */
    public function testNewActivityTypeSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_TYPE_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_activity_type', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_TYPE_LIST));

        $activityType = $em->getRepository(ActivityType::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(ActivityType::class, $activityType);

    }

    /**
     * @return array[]
     * @throws ActivityModeNotFoundException
     */
    public function newActivityTypeSuccessfulProvider(): array
    {
        $icon = $this->client()->getKernel()->getProjectDir() . '/tests/Resources/File/icon.png';
        $activityMode = $this->getActivityMode();

        return [
            [
                ['label' => 'ActivityTypeTest42'],
                ['label' => 'ActivityTypeTest42', 'activityModes' => $activityMode->getId(), 'icon' => $icon],
            ]
        ];
    }

    /**
     * @dataProvider newActivityTypeNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewActivityTypeNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_TYPE_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_activity_type', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_activity_type' . $fieldName, $tagName);

        $user = $em->getRepository(ActivityType::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newActivityTypeNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]'],
        ];
    }

    /*
     *  Edit Activity Type
     */

    /**
     * @throws ActivityTypeNotFoundException
     */
    public function testEditActivityTypeUserNotAuthenticated()
    {
        $activityType = $this->getActivityType();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_TYPE_EDIT, ['id' => $activityType->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws ActivityTypeNotFoundException
     */
    public function testEditActivityTypeWithAdminPermission()
    {
        $activityType = $this->getActivityType();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_TYPE_EDIT, ['id' => $activityType->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editActivityTypeWithMissingRoleProvider
     * @param array $data
     * @throws ActivityTypeNotFoundException
     */
    public function testEditActivityTypeWithMissingRole(array $data)
    {
        $activityType = $this->getActivityType();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_TYPE_EDIT, ['id' => $activityType->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editActivityTypeWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYTYPE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYTYPE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYTYPE', 'ROLE_ADMIN_ACTIVITYTYPE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYTYPE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYTYPE_UPDATE']],
        ];
    }

    public function testEditActivityTypeWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_MODE_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editActivityTypeSuccessfulProvider
     * @param array $data
     */
    public function testEditActivityTypeSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $activityType = new ActivityType();
        $activityType->setLabel('Fake');

        $em->persist($activityType);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_TYPE_EDIT, ['id' => $activityType->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_activity_type',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var ActivityType $updatedActivityType */
        $updatedActivityType = $em->getRepository(ActivityType::class)->find($activityType->getId());

        $this->assertCheckEntityProps($updatedActivityType, $data);
    }

    /**
     * @return array
     */
    public function editActivityTypeSuccessfulProvider(): array
    {
        return [
            [
                ['label' => 'ActivityTypeTest42']
            ]
        ];
    }

    /**
     * @dataProvider editActivityTypeNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws ActivityTypeNotFoundException
     */
    public function testEditActivityTypeNotValid(array $data, $fieldName, $tagName = null)
    {
        $activityType = $this->getActivityType();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_TYPE_EDIT, ['id' => $activityType->getId()]));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_activity_type', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_activity_type' . $fieldName, $tagName);
    }

    /**
     * @return array[]
     */
    public function editActivityTypeNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }
}