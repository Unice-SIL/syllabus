<?php


namespace Tests\Syllabus\Controller\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebTestCase;

/**
 * Class AskAdviceControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class AskAdviceControllerTest extends WebTestCase
{
    public function testAskAdviceUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ASK_ADVICE_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testAskAdviceRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ASK_ADVICE_LIST));
        $this->assertResponseIsSuccessful();
    }

    public function testAskAdviceWithoutPermission()
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_USER'])
            ->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login($user);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ASK_ADVICE_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

    }
}