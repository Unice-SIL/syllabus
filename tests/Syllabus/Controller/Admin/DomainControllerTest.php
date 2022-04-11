<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Domain;
use App\Syllabus\Entity\Structure;
use App\Syllabus\Exception\DomainNotFoundException;
use App\Syllabus\Exception\StructureNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DomainControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class DomainControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Domain List
     */

    public function testDomainListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_DOMAIN_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testDomainListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_DOMAIN_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider domainListWithMissingRoleProvider
     * @param array $data
     */
    public function testDomainListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_DOMAIN_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function domainListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_DOMAIN']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_DOMAIN_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_DOMAIN', 'ROLE_ADMIN_DOMAIN_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_DOMAIN']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_DOMAIN_LIST']],
        ];
    }

    /**
     * @throws DomainNotFoundException
     * @throws StructureNotFoundException
     */
    public function testDomainFilter()
    {
        $domain = $this->getDomain();
        if ($domain->getStructures()->isEmpty()) {
            $domain->addStructure($this->getStructure());
        }
        $this->getEntityManager()->persist($domain);
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_DOMAIN_LIST, [
            'domain_filter' => [
                'label' => $this->getDomain()->getLabel(),
                'structures' => $this->getDomain()->getStructures()->current()->getLabel()
            ]
        ]);
        $this->assertResponseIsSuccessful();
    }

    /*
     *  New Domain
     */

    public function testDomainNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_DOMAIN_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testDomainNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_DOMAIN_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider domainNewWithMissingRoleProvider
     * @param array $data
     */
    public function testDomainNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_DOMAIN_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function domainNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_DOMAIN']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_DOMAIN_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_DOMAIN', 'ROLE_ADMIN_DOMAIN_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_DOMAIN']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_DOMAIN_CREATE']],
        ];
    }

    /**
     * @dataProvider newDomainSuccessfulProvider
     * @param array $data
     */
    public function testNewDomainSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_DOMAIN_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_domain', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_DOMAIN_LIST));

        $domain = $em->getRepository(Domain::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(Domain::class, $domain);

        $this->assertCheckEntityProps($domain, $data, [
            'structures' => function ($entity, $value) {
                $this->assertCount(1,
                    array_filter($entity->getStructures()->toArray(), function (Structure $structure) use ($value) {
                        return $structure->getId() === $value;
                    })
                );
            }
        ]);
    }

    /**
     * @return array
     * @throws StructureNotFoundException
     */
    public function newDomainSuccessfulProvider(): array
    {
        $structure = $this->getStructure();
        return [
            [['label' => 'DomainTest']],
            [['label' => 'DomainTest', 'grp' => 'groupTest', 'structures' => $structure->getId()]]
        ];
    }

    /**
     * @dataProvider newDomainNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewDomainNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_DOMAIN_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_domain', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_domain' . $fieldName, $tagName);

        $user = $em->getRepository(Domain::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newDomainNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }

    /*
     *  Edit Campus
     */

    /**
     * @throws DomainNotFoundException
     */
    public function testEditDomainUserNotAuthenticated()
    {
        $domain = $this->getDomain();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_DOMAIN_EDIT, ['id' => $domain->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws DomainNotFoundException
     */
    public function testEditDomainWithAdminPermission()
    {
        $domain = $this->getDomain();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_DOMAIN_EDIT, ['id' => $domain->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editDomainWithMissingRoleProvider
     * @param array $data
     * @throws DomainNotFoundException
     */
    public function testEditDomainWithMissingRole(array $data)
    {
        $domain = $this->getDomain();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_DOMAIN_EDIT, ['id' => $domain->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editDomainWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_DOMAIN']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_DOMAIN_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_DOMAIN', 'ROLE_ADMIN_DOMAIN_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_DOMAIN']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_DOMAIN_UPDATE']],
        ];
    }

    public function testEditDomainWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_DOMAIN_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editDomainSuccessfulProvider
     * @param array $data
     */
    public function testEditDomainSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $domain = new Domain();
        $domain->setLabel('Fake');

        $em->persist($domain);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_DOMAIN_EDIT, ['id' => $domain->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_domain',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var Domain $updatedDomain */
        $updatedDomain = $em->getRepository(Domain::class)->find($domain->getId());

        $this->assertCheckEntityProps($updatedDomain, $data);
    }

    /**
     * @return array
     */
    public function editDomainSuccessfulProvider(): array
    {
        return [
            [['label' => 'DomainTest']]
        ];
    }

    /**
     * @dataProvider editDomainNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws DomainNotFoundException
     */
    public function testEditDomainNotValid(array $data, $fieldName, $tagName = null)
    {
        $domain = $this->getDomain();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_DOMAIN_EDIT, ['id' => $domain->getId()]));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_domain', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_domain' . $fieldName, $tagName);
    }

    /**
     * @return array[]
     */
    public function editDomainNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }
}