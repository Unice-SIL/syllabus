<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\ActivityMode;
use App\Syllabus\Exception\ActivityModeNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ActivityModeControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ActivityModeControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Activity Mode List
     */

    public function testActivityModeUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityModeWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider activityModeWithMissingRoleProvider
     * @param array $data
     */
    public function testActivityModeWithMissingRole(array $data)
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
    public function activityModeWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYMODE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYMODE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYMODE', 'ROLE_ADMIN_ACTIVITYMODE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYMODE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYMODE_LIST']],
        ];
    }

    /**
     * @throws ActivityModeNotFoundException
     */
    public function testLanguageFilter()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST, [
            'activity_mode_filter' => [
                'label' => $this->getActivityMode()->getLabel()
            ]
        ]);
        $this->assertResponseIsSuccessful();
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
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYMODE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYMODE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYMODE', 'ROLE_ADMIN_ACTIVITYMODE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYMODE']],
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

        $this->submitForm($crawler->filter('button[type="submit"]'), 'activity_mode', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST));

        $activityMode = $em->getRepository(ActivityMode::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(ActivityMode::class, $activityMode);

        $this->assertCheckEntityProps($activityMode, $data);
    }

    /**
     * @return array
     */
    public function newActivityModeSuccessfulProvider(): array
    {
        return [
            [['label' => 'ActivityModeTest42']]
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
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYMODE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITYMODE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYMODE', 'ROLE_ADMIN_ACTIVITYMODE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITYMODE']],
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

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'activity_mode',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var ActivityMode $updatedActivityMode */
        $updatedActivityMode = $em->getRepository(ActivityMode::class)->find($activityMode->getId());

        $this->assertCheckEntityProps($updatedActivityMode, $data);
    }

    /**
     * @return array
     */
    public function editActivityModeSuccessfulProvider(): array
    {
        return [
            [['label' => 'ActivityModeTest42']]
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