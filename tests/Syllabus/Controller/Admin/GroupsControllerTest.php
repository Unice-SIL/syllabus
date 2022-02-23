<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Constant\UserRole;
use App\Syllabus\Entity\Groups;
use App\Syllabus\Exception\GroupsNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GroupsControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class GroupsControllerTest extends AbstractAdminControllerTest
{
    public function testGroupsListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_GROUPS_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testGroupsListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_GROUPS_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @return void
     * @throws GroupsNotFoundException
     */
    public function testGroupsFilter()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_GROUPS_LIST, [
            'groups_filter' => [
                'label' => $this->getGroupsUser()->getLabel()
            ]
        ]);
        $this->assertResponseIsSuccessful();
    }

    public function testGroupsNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_GROUPS_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testGroupsNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_GROUPS_NEW);
        $this->assertResponseIsSuccessful();
    }

    public function testGroupsNewWithMissingRole()
    {
        $this->getUser()->setRoles(['ROLE_USER'])->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_GROUPS_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @dataProvider newGroupsSuccessfulProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testNewGroupsSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_GROUPS_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'groups', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_GROUPS_LIST));

        $group = $em->getRepository(Groups::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(Groups::class, $group);

        $this->assertCheckEntityProps($group, $data);
    }

    /**
     * @return array
     */
    public function newGroupsSuccessfulProvider(): array
    {
        return [
            [
                [
                    'label' => 'GroupTest42',
                    'roles' => [UserRole::ROLE_SUPER_ADMIN]
                ]
            ]
        ];
    }
}