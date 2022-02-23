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
     * @dataProvider groupsListWithMissingRoleProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testGroupsListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_GROUPS_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function groupsListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_GROUPS']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_GROUPS_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS', 'ROLE_ADMIN_GROUPS_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS_LIST']],
        ];
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

    /**
     * @dataProvider groupsNewWithMissingRoleProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testGroupsNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_GROUPS_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function groupsNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_GROUPS']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_GROUPS_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS', 'ROLE_ADMIN_GROUPS_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS_CREATE']],
        ];
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

    /**
     * @return void
     * @throws GroupsNotFoundException
     */
    public function testGroupsEditUserNotAuthenticated()
    {
        $groups = $this->getGroupsUser();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_GROUPS_EDIT, ['id' => $groups->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @return void
     * @throws GroupsNotFoundException
     */
    public function testGroupsEditWithAdminPermission()
    {
        $groups = $this->getGroupsUser();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_GROUPS_EDIT, ['id' => $groups->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider groupsEditWithMissingRoleProvider
     * @param array $data
     * @throws UserNotFoundException|GroupsNotFoundException
     */
    public function testGroupsEditWithMissingRole(array $data)
    {
        $groups = $this->getGroupsUser();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_GROUPS_EDIT, ['id' => $groups->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function groupsEditWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_GROUPS']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_GROUPS_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS', 'ROLE_ADMIN_GROUPS_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS_UPDATE']],
        ];
    }

    /**
     * @dataProvider editGroupsSuccessfulProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testEditGroupsSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $groups = new Groups();
        $groups
            ->setLabel('Fake')
            ->setRoles([UserRole::ROLE_ADMIN]);

        $em->persist($groups);
        $em->flush();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_GROUPS_EDIT,
            ['id' => $groups->getId()]));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'groups', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_GROUPS_EDIT, ['id' => $groups->getId()]));

        /** @var Groups $updatedGroups */
        $updatedGroups = $em->getRepository(Groups::class)->find($groups->getId());

        $this->assertCheckEntityProps($updatedGroups, $data);
    }

    /**
     * @return array
     */
    public function editGroupsSuccessfulProvider(): array
    {
        return [
            [
                [
                    'label' => 'GroupTest42',
                ]
            ],
            [
                [
                    'roles' =>
                        [
                            UserRole::ROLE_ADMIN,
                            UserRole::ROLE_SUPER_ADMIN,
                        ]
                ]
            ]
        ];
    }

    /**
     * @return void
     * @throws GroupsNotFoundException
     */
    public function testGroupsDeleteUserNotAuthenticated()
    {
        $groups = $this->getGroupsUser();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_GROUPS_DELETE, ['id' => $groups->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @return void
     * @throws GroupsNotFoundException
     */
    public function testGroupsDeleteWithAdminPermission()
    {
        $groups = $this->getGroupsUser();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_GROUPS_DELETE, ['id' => $groups->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider groupsDeleteWithMissingRoleProvider
     * @param array $data
     * @throws UserNotFoundException|GroupsNotFoundException
     */
    public function testGroupsDeleteWithMissingRole(array $data)
    {
        $groups = $this->getGroupsUser();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_GROUPS_DELETE, ['id' => $groups->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function groupsDeleteWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_GROUPS']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_GROUPS_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS', 'ROLE_ADMIN_GROUPS_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_GROUPS_UPDATE']],
        ];
    }

}