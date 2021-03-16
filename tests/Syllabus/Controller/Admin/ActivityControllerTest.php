<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Activity;
use App\Syllabus\Entity\ActivityType;
use App\Syllabus\Exception\ActivityNotFoundException;
use App\Syllabus\Fixture\ActivityTypeFixture;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Class ActivityControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ActivityControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Activity List
     */

    public function testActivityListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider activityListWithMissingRoleProvider
     * @param array $data
     */
    public function testActivityListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function activityListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITY_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY', 'ROLE_ADMIN_ACTIVITY_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY_LIST']],
        ];
    }

    /*
     *  New Activity
     */

    public function testActivityNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider activityNewWithMissingRoleProvider
     * @param array $data
     */
    public function testActivityNewWithMissingRole(array $data)
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
    public function activityNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITY_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY', 'ROLE_ADMIN_ACTIVITY_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY_CREATE']],
        ];
    }

    /**
     * @dataProvider newActivitySuccessfulProvider
     * @param array $data
     */
    public function testNewActivitySuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_NEW));

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_activity',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_LIST));

        $activity = $em->getRepository(Activity::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(Activity::class, $activity);

        $this->assertCheckEntityProps($activity, $data, [
            'activityTypes' => function ($entity, $value) {
                $this->assertCount(1,
                    array_filter($entity->getActivityTypes()->toArray(), function (ActivityType $activityType) use ($value) {
                        return $activityType->getId() === $value;
                    })
                );
                $this->assertCount(1, $entity->getActivityTypes());
            }
        ]);
    }

    /**
     * @return array
     */
    public function newActivitySuccessfulProvider(): array
    {
        $em = $this->getEntityManager();
        $activityType =  $em->getRepository(ActivityType::class)
            ->findOneBy(['label' => ActivityTypeFixture::ACTIVITY_TYPE_DISTANT])->getId();
        return [
            [
                ['label' => 'ActivityTest42', 'description' => 'Description Test', 'activityTypes' => $activityType],
                ['label' => 'ActivityTest42', 'activityTypes' => $activityType]
            ]
        ];
    }

    /**
     * @dataProvider newActivityNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewActivityNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_activity', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_activity' . $fieldName, $tagName);

        $user = $em->getRepository(Activity::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newActivityNotValidProvider(): array
    {
        $em = $this->getEntityManager();
        $activityType =  $em->getRepository(ActivityType::class)
            ->findOneBy(['label' => ActivityTypeFixture::ACTIVITY_TYPE_DISTANT])->getId();

        return [
            [['label' => 'ActivityTest42'], '[activityTypes][]', 'select'],
            [['activityTypes' => $activityType], '[label]']
        ];
    }

    /*
     *  Edit Activity
     */

    /**
     * @throws ActivityNotFoundException
     */
    public function testEditActivityUserNotAuthenticated()
    {
        $activity = $this->getActivity();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_EDIT, ['id' => $activity->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws ActivityNotFoundException
     */
    public function testEditActivityWithAdminPermission()
    {
        $activity = $this->getActivity();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_EDIT, ['id' => $activity->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editActivityWithMissingRoleProvider
     * @param array $data
     * @throws ActivityNotFoundException
     */
    public function testEditActivityWithMissingRole(array $data)
    {
        $activity = $this->getActivity();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_EDIT, ['id' => $activity->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editActivityWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITY_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY', 'ROLE_ADMIN_ACTIVITY_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_ACTIVITY_UPDATE']],
        ];
    }

    public function testEditActivityWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editActivitySuccessfulProvider
     * @param array $data
     */
    public function testEditActivitySuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        /** @var ActivityType $activityType */
        $activityType =  $em->getRepository(ActivityType::class)
            ->findOneBy(['label' => ActivityTypeFixture::ACTIVITY_TYPE_DISTANT]);

        $activity = new Activity();
        $activity->setLabel('Fake')
            ->addActivityType($activityType);

        $em->persist($activity);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_EDIT, ['id' => $activity->getId()])
        );

        $formData = $data;
        $formData['activityTypes'] = $formData['activityTypes']->getId();

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_activity',
            $formData
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var Activity $updatedActivity */
        $updatedActivity = $em->getRepository(Activity::class)->find($activity->getId());

        $this->assertCheckEntityProps($updatedActivity, $data, [
            'activityTypes' => function ($entity, $value) {
                $this->assertCount(1,
                    array_filter($entity->getActivityTypes()->toArray(), function (ActivityType $activityType) use ($value) {
                        return $activityType->getId() === $value->getId();
                    })
                );
                $this->assertCount(1, $entity->getActivityTypes());
            }
        ]);
    }

    /**
     * @return array
     */
    public function editActivitySuccessfulProvider(): array
    {
        $em = $this->getEntityManager();
        $activityType =  $em->getRepository(ActivityType::class)
            ->findOneBy(['label' => ActivityTypeFixture::ACTIVITY_TYPE_AUTONOMY]);
        return [
            [
                ['label' => 'ActivityTest42', 'description' => 'Description Test', 'activityTypes' => $activityType]
            ]
        ];
    }

    /**
     * @dataProvider editActivityNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws ActivityNotFoundException
     */
    public function testEditActivityNotValid(array $data, $fieldName, $tagName = null)
    {
        $activity = $this->getActivity();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_EDIT, ['id' => $activity->getId()]));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_activity', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_activity' . $fieldName, $tagName);
    }

    /**
     * @return array[]
     */
    public function editActivityNotValidProvider(): array
    {
        $em = $this->getEntityManager();
        $activityType =  $em->getRepository(ActivityType::class)
            ->findOneBy(['label' => ActivityTypeFixture::ACTIVITY_TYPE_DISTANT])->getId();

        return [
            [['label' => 'ActivityTest42'], '[activityTypes][]', 'select'],
            [['label' => null, 'activityTypes' => $activityType], '[label]']
        ];
    }
}