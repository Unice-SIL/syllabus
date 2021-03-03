<?php


namespace Tests\Syllabus\Controller\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebTestCase;

/**
 * Class ActivityControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ActivityControllerTest extends WebTestCase
{
    public function testActivityListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_LIST));
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider activityListWithMissingRoleProvider
     * @param array $data
     */
/*    public function testActivityListWithMissingRole(array $data)
    {
        $user = $this->getUser();
        $user->setRoles($data)
            ->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login($user);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }*/

    /**
     * @return array[]
     */
/*    public function activityListWithMissingRoleProvider(): array
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

    public function testActivityListWithMissingRoleList()
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_ACTIVITY', 'ROLE_ADMIN_ACTIVITY_LIST'])
            ->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login($user);
        var_dump($user->getRoles());
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }*/
}