<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Structure;
use App\Syllabus\Exception\StructureNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StructureControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class StructureControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Structure List
     */
    public function testStructureListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_STRUCTURE_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testStructureListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_STRUCTURE_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider structureListWithMissingRoleProvider
     * @param array $data
     */
    public function testStructureListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_STRUCTURE_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function structureListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_STRUCTURE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_STRUCTURE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_STRUCTURE', 'ROLE_ADMIN_STRUCTURE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_STRUCTURE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_STRUCTURE_LIST']],
        ];
    }

    /*
     *  New Structure
     */

    public function testStructureNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_STRUCTURE_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testStructureNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_STRUCTURE_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider structureNewWithMissingRoleProvider
     * @param array $data
     */
    public function testStructureNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_STRUCTURE_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function structureNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_STRUCTURE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_STRUCTURE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_STRUCTURE', 'ROLE_ADMIN_STRUCTURE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_STRUCTURE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_STRUCTURE_CREATE']],
        ];
    }

    /**
     * @dataProvider newStructureSuccessfulProvider
     * @param array $data
     */
    public function testNewStructureSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_STRUCTURE_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_structure', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_STRUCTURE_LIST));

        $campus = $em->getRepository(Structure::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(Structure::class, $campus);

        $this->assertCheckEntityProps($campus, $data);
    }

    /**
     * @return array
     */
    public function newStructureSuccessfulProvider(): array
    {
        return [
            [['label' => 'StructureTest']],
            [['label' => 'StructureTest', 'code' => 'fakeCode']]
        ];
    }

    /**
     * @dataProvider newStructureNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewStructureNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_STRUCTURE_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_structure', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_structure' . $fieldName, $tagName);

        $user = $em->getRepository(Structure::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newStructureNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }

    /*
     *  Edit Campus
     */

    /**
     * @throws StructureNotFoundException
     */
    public function testEditStructureUserNotAuthenticated()
    {
        $structure = $this->getStructure();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_STRUCTURE_EDIT, ['id' => $structure->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws StructureNotFoundException
     */
    public function testEditStructureWithAdminPermission()
    {
        $structure = $this->getStructure();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_STRUCTURE_EDIT, ['id' => $structure->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editStructureWithMissingRoleProvider
     * @param array $data
     * @throws StructureNotFoundException
     */
    public function testEditStructureWithMissingRole(array $data)
    {
        $structure = $this->getStructure();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_STRUCTURE_EDIT, ['id' => $structure->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editStructureWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_STRUCTURE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_STRUCTURE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_STRUCTURE', 'ROLE_ADMIN_STRUCTURE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_STRUCTURE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_STRUCTURE_UPDATE']],
        ];
    }

    public function testEditStructureWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_STRUCTURE_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editStructureSuccessfulProvider
     * @param array $data
     */
    public function testEditStructureSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $structure = new Structure();
        $structure->setLabel('Fake');

        $em->persist($structure);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_STRUCTURE_EDIT, ['id' => $structure->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_structure',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var Structure $updatedStructure */
        $updatedStructure = $em->getRepository(Structure::class)->find($structure->getId());

        $this->assertCheckEntityProps($updatedStructure, $data);
    }

    /**
     * @return array
     */
    public function editStructureSuccessfulProvider(): array
    {
        return [
            [['obsolete' => true]]
        ];
    }
}