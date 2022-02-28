<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Course;
use App\Syllabus\Entity\CriticalAchievement;
use App\Syllabus\Exception\CriticalAchievementNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CriticalAchievementControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CriticalAchievementControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Critical Achievement List
     */

    public function testCriticalAchievementListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCriticalAchievementListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider criticalAchievementListWithMissingRoleProvider
     * @param array $data
     */
    public function testCriticalAchievementListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function criticalAchievementListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_LIST']],
        ];
    }

    /*
     *  New CriticalAchievement
     */

    public function testCriticalAchievementNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCriticalAchievementNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider criticalAchievementNewWithMissingRoleProvider
     * @param array $data
     */
    public function testCriticalAchievementNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function criticalAchievementNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_CREATE']],
        ];
    }

    /**
     * @dataProvider newCriticalAchievementSuccessfulProvider
     * @param array $data
     */
    public function testNewCriticalAchievementSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_NEW));

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'critical_achievement',
            $data
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_LIST));

        /** @var CriticalAchievement $criticalAchievement */
        $criticalAchievement = $em->getRepository(CriticalAchievement::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(CriticalAchievement::class, $criticalAchievement);

        $this->assertCheckEntityProps($criticalAchievement, $data, [
            'courses' => function ($entity, $value) {
                $this->assertCount(1,
                    array_filter($entity->getCourses()->toArray(), function (Course $course) use ($value) {
                        return $course->getId() === $value;
                    })
                );
            }
        ]);

    }

    /**
     * @return array
     */
    public function newCriticalAchievementSuccessfulProvider(): array
    {
        $course = $this->getCourseInfo(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);

        return [
            [['label' => 'CriticalAchievementTest']],
            [['label' => 'CriticalAchievementTest', 'courses' => $course->getCourse()->getId()]]
        ];
    }


    /**
     * @dataProvider newCriticalAchievementNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewCriticalAchievementModeNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'critical_achievement', $data);

        $this->assertInvalidFormField($crawler, 'critical_achievement' . $fieldName, $tagName);

        $user = $em->getRepository(CriticalAchievement::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newCriticalAchievementNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]'],
        ];
    }

    /*
     *  Edit Activity Mode
     */

    /**
     * @throws CriticalAchievementNotFoundException
     */
    public function testEditCriticalAchievementUserNotAuthenticated()
    {
        $criticalAchievement = $this->getCriticalAchievement();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_EDIT, ['id' => $criticalAchievement->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CriticalAchievementNotFoundException
     */
    public function testEditCriticalAchievementWithAdminPermission()
    {
        $criticalAchievement = $this->getCriticalAchievement();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_EDIT, ['id' => $criticalAchievement->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editCriticalAchievementWithMissingRoleProvider
     * @param array $data
     * @throws CriticalAchievementNotFoundException
     */
    public function testEditCriticalAchievementWithMissingRole(array $data)
    {
        $criticalAchievement = $this->getCriticalAchievement();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_EDIT, ['id' => $criticalAchievement->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editCriticalAchievementWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_CRITICAL_ACHIEVEMENT_UPDATE']],
        ];
    }

    public function testEditCriticalAchievementWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editCriticalAchievementSuccessfulProvider
     * @param array $data
     */
    public function testEditCriticalAchievementSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $criticalAchievement = new CriticalAchievement();
        $criticalAchievement->setLabel('Fake');

        $em->persist($criticalAchievement);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_EDIT, ['id' => $criticalAchievement->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'critical_achievement',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var CriticalAchievement $updatedCriticalAchievement */
        $updatedCriticalAchievement = $em->getRepository(CriticalAchievement::class)->find($criticalAchievement ->getId());

        $this->assertCheckEntityProps($updatedCriticalAchievement, $data);
    }

    /**
     * @return array
     */
    public function editCriticalAchievementSuccessfulProvider(): array
    {
        return [
            [['label' => 'CriticalAchievementTest42']]
        ];
    }

    /**
     * @dataProvider editCriticalAchievementNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws CriticalAchievementNotFoundException
     */
    public function testEditCriticalAchievementNotValid(array $data, $fieldName, $tagName = null)
    {
        $criticalAchievement = $this->getCriticalAchievement();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_EDIT, ['id' => $criticalAchievement->getId()]));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'critical_achievement', $data);

        $this->assertInvalidFormField($crawler, 'critical_achievement' . $fieldName, $tagName);
    }

    /**
     * @return array[]
     */
    public function editCriticalAchievementNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }
}