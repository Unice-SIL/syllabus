<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\User;
use App\Syllabus\Exception\GroupsNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class UserControllerTest extends AbstractAdminControllerTest
{
    public function testUserListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_USER_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testUserListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_USER_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider usersListWithMissingRoleProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testUsersListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_USER_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function usersListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_USER']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_USER_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_USER', 'ROLE_ADMIN_USER_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_USER']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_USER_LIST']],
        ];
    }

    /**
     * @dataProvider userFilterProvider
     * @param array $filter
     * @return void
     */
    public function testUserFilter(array $filter)
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_USER_LIST, [
            'user_filter' => $filter
        ]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @return array
     * @throws UserNotFoundException
     */
    public function userFilterProvider(): array
    {
        return [
            [
                ['username' => $this->getUser()->getUsername()]
            ],
            [
                ['lastname' => $this->getUser()->getLastname()]
            ],
            [
                ['email' => $this->getUser()->getEmail()]
            ],
        ];
    }

    public function testNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_USER_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testNewUserWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_USER_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider newUserWithMissingRoleProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testNewUserWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_USER_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function newUserWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_USER']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_USER_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_USER', 'ROLE_ADMIN_USER_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_USER']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_USER_CREATE']],
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
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_USER_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_user', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_USER_LIST));
        $user = $em->getRepository(User::class)->findOneBy(['username' => $data['username'] ?? '']);

        $this->assertInstanceOf(User::class, $user);
        $this->assertCheckEntityProps($user, $data);
    }

    /**
     * @return array
     */
    public function newGroupsSuccessfulProvider(): array
    {
        return [
            [
                [
                    'username' => 'mjordan',
                    'lastname' => 'jordan',
                    'firstname' => 'michael',
                    'email' => 'mjordan@hornet.com'
                ]
            ]
        ];
    }

    /**
     * @dataProvider newUserNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws UserNotFoundException
     */
    public function testNewUserNotValid(array $invalidValue, $fieldName, $tagName = null)
    {
        $data = [
            'username' => 'mjordan',
            'lastname' => 'jordan',
            'firstname' => 'michael',
            'email' => 'mjordan@hornet.com'
        ];
        $data[key($invalidValue)] = $invalidValue[key($invalidValue)];
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_USER_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_user', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_user' . $fieldName, $tagName);

        $user = $em->getRepository(User::class)
            ->findOneBy(['username' => $data['username'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newUserNotValidProvider(): array
    {
        return [
            [
                ['username' => null],
                '[username]'
            ],
            [
                ['username' => ''],
                '[username]'
            ],
            [
                ['lastname' => null],
                '[lastname]'
            ],
            [
                ['lastname' => ''],
                '[lastname]'
            ],
            [
                ['firstname' => null],
                '[firstname]'
            ],
            [
                ['firstname' => ''],
                '[firstname]'
            ],
            [
                ['firstname' => ''],
                '[firstname]'
            ],
            [
                ['email' => null],
                '[email]'
            ],
            [
                ['email' => ''],
                '[email]'
            ],
            [
                ['email' => 'mjordan'],
                '[email]'
            ],
            [
                ['email' => 'mjordan@hornet'],
                '[email]'
            ],
            [
                ['email' => 'mjordan.com'],
                '[email]'
            ],
            [
                ['email' => '@hornet.com'],
                '[email]'
            ],
        ];
    }

    /**
     * @throws UserNotFoundException
     */
    public function testEditUserUserNotAuthenticated()
    {
        $user = $this->getUser();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_USER_EDIT, ['id' => $user->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws UserNotFoundException
     */
    public function testEditUserWithAdminPermission()
    {
        $user = $this->getUser();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_USER_EDIT, ['id' => $user->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editUserWithMissingRoleProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testEditUserWithMissingRole(array $data)
    {
        $user = $this->getUser();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_USER_EDIT, ['id' => $user->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editUserWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_USER']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_USER_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_USER', 'ROLE_ADMIN_USER_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_USER']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_USER_UPDATE']],
        ];
    }

    /**
     * @dataProvider editUserSuccessfulProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testEditUserSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $user = new User();
        $user->setUsername('Fake')
            ->setLastname('Fake')
            ->setFirstname('Fake')
            ->setEmail('fake@fake.com');

        $em->persist($user);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_USER_EDIT, ['id' => $user->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_user',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var User $updatedUser */
        $updatedUser = $em->getRepository(User::class)->find($user->getId());

        $this->assertEquals($updatedUser->getGroups()->current()->getId(), $data['groups']);
    }

    /**
     * @return \array[][]
     * @throws GroupsNotFoundException
     */
    public function editUserSuccessfulProvider(): array
    {
        return [
            [
                [
                   'groups' => $this->getGroupsUser()->getId()
                ]
            ]
        ];
    }

    public function testEditUserWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_USER_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }


    /**
     * @throws UserNotFoundException
     */
    public function testSendingTokenUserUserNotAuthenticated()
    {
        $user = $this->getUser();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_USER_SEND_PASSWORD, ['id' => $user->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws UserNotFoundException
     */
    public function testSendingTokenUserWithAdminPermissionSuccess()
    {
        $user = $this->getUser();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_USER_SEND_PASSWORD, ['id' => $user->getId()]);
        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_USER_EDIT, ['id' => $user->getId()]));
    }

    /**
     * @dataProvider sendingTokenUserWithMissingRoleProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testSendingTokenUserWithMissingRole(array $data)
    {
        $user = $this->getUser();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_USER_SEND_PASSWORD, ['id' => $user->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function sendingTokenUserWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_USER']],
            [['ROLE_USER']],
        ];
    }

    public function testSendingTokenUserWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_USER_SEND_PASSWORD, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
