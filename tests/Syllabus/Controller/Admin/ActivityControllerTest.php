<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Activity;
use App\Syllabus\Entity\ActivityType;
use App\Syllabus\Fixture\ActivityTypeFixture;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ActivityControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ActivityControllerTest extends AbstractAdminControllerTest
{
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
     * @dataProvider newActivitySuccessfulProvider
     * @param array $data
     */
    public function testNewActivitySuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_NEW));
        $form = $crawler->filter('button[type="submit"]')->form();
        foreach ($data as $field => $value)
        {
            $form['appbundle_activity[' . $field . ']']->setValue($value);
        }
        $activityType =  $em->getRepository(ActivityType::class)
            ->findOneBy(['label' => ActivityTypeFixture::ACTIVITY_TYPE_DISTANT]);
        $form['appbundle_activity[activityTypes]']->setValue($activityType->getId());
        $this->client()->submit($form);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_LIST));

        $activity = $em->getRepository(Activity::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(Activity::class, $activity);
    }

    /**
     * @return array
     */
    public function newActivitySuccessfulProvider(): array
    {
        return [
          [
              ['label' => 'ActivityTest42', 'description' => 'Description Test']
          ]
        ];
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
}