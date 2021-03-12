<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\ActivityMode;
use App\Syllabus\Exception\ActivityModeNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class ActivityModeControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ActivityModeControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Activity Mode List
     */

    public function testActivityModeListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityModeListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider activityModeListWithMissingRoleProvider
     * @param array $data
     */
    public function testActivityModeListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function activityModeListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYMODE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY', 'ROLE_ADMIN_ACTIVITYMODE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYMODE_LIST']],
        ];
    }

    /*
     *  New Activity Mode
     */

    public function testActivityModeNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_MODE_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityModeNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_MODE_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider activityModeNewWithMissingRoleProvider
     * @param array $data
     */
    public function testActivityModeNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function activityModeNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYMODE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY', 'ROLE_ADMIN_ACTIVITYMODE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYMODE_CREATE']],
        ];
    }

    /**
     * @dataProvider newActivityModeSuccessfulProvider
     * @param array $data
     */
    public function testNewActivityModeSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_MODE_NEW));
        $form = $crawler->filter('button[type="submit"]')->form();
        foreach ($data as $field => $value)
        {
            $form['activity_mode[' . $field . ']']->setValue($value);
        }
        $this->client()->submit($form);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST));

        $activity = $em->getRepository(ActivityMode::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(ActivityMode::class, $activity);
    }

    /**
     * @return array
     */
    public function newActivityModeSuccessfulProvider(): array
    {
        return [
            [
                ['label' => 'ActivityTest42']
            ]
        ];
    }

    /**
     * @dataProvider newActivityModeNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewActivityModeNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_MODE_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'activity_mode', $data);

        $this->assertInvalidFormField($crawler, 'activity_mode' . $fieldName, $tagName);

        $user = $em->getRepository(ActivityMode::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newActivityModeNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]'],
        ];
    }

    /*
     *  Edit Activity Mode
     */

    /**
     * @throws ActivityModeNotFoundException
     */
    public function testEditActivityModeUserNotAuthenticated()
    {
        $activityMode = $this->getActivityMode();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_MODE_EDIT, ['id' => $activityMode->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws ActivityModeNotFoundException
     */
    public function testEditActivityModeWithAdminPermission()
    {
        $activityMode = $this->getActivityMode();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_MODE_EDIT, ['id' => $activityMode->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editActivityModeWithMissingRoleProvider
     * @param array $data
     * @throws ActivityModeNotFoundException
     */
    public function testEditActivityModeWithMissingRole(array $data)
    {
        $activityMode = $this->getActivityMode();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_MODE_EDIT, ['id' => $activityMode->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editActivityModeWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYMODE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY', 'ROLE_ADMIN_ACTIVITYMODE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYMODE_UPDATE']],
        ];
    }

    public function testEditActivityModeWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_MODE_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editActivityModeSuccessfulProvider
     * @param array $data
     */
    public function testEditActivityModeSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $activityMode = new ActivityMode();
        $activityMode->setLabel('Fake');

        $em->persist($activityMode);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_MODE_EDIT, ['id' => $activityMode->getId()])
        );
        $form = $crawler->filter('button[type="submit"]')->form();
        foreach ($data as $field => $value)
        {
            $form['activity_mode[' . $field . ']']->setValue($value);
        }
        $this->client()->submit($form);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var ActivityMode $updatedActivityMode */
        $updatedActivityMode = $em->getRepository(ActivityMode::class)->find($activityMode->getId());

        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($data as $field => $value)
        {
            $this->assertEquals($value, $propertyAccessor->getValue($updatedActivityMode, $field));
        }

    }

    /**
     * @return array
     */
    public function editActivityModeSuccessfulProvider(): array
    {
        return [
            [
                ['label' => 'ActivityTest42']
            ]
        ];
    }

    /**
     * @dataProvider editActivityModeNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws ActivityModeNotFoundException
     */
    public function testEditActivityModeNotValid(array $data, $fieldName, $tagName = null)
    {
        $activityMode = $this->getActivityMode();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_MODE_EDIT, ['id' => $activityMode->getId()]));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'activity_mode', $data);

        $this->assertInvalidFormField($crawler, 'activity_mode' . $fieldName, $tagName);
    }

    /**
     * @return array[]
     */
    public function editActivityModeNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }
}