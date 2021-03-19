<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Equipment;
use App\Syllabus\Exception\EquipmentNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EquipmentControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class EquipmentControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Equipment List
     */

    public function testEquipmentListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_EQUIPMENT_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testEquipmentListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_EQUIPMENT_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider equipmentListWithMissingRoleProvider
     * @param array $data
     */
    public function testEquipmentListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_EQUIPMENT_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function equipmentListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_EQUIPMENT']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_EQUIPMENT_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_EQUIPMENT', 'ROLE_ADMIN_EQUIPMENT_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_EQUIPMENT']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_EQUIPMENT_LIST']],
        ];
    }

    /*
     *  New Equipment
     */

    public function testEquipmentNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_EQUIPMENT_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testEquipmentNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_EQUIPMENT_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider equipmentNewWithMissingRoleProvider
     * @param array $data
     */
    public function testEquipmentNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_EQUIPMENT_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function equipmentNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_EQUIPMENT']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_EQUIPMENT_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_EQUIPMENT', 'ROLE_ADMIN_EQUIPMENT_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_EQUIPMENT']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_EQUIPMENT_CREATE']],
        ];
    }

    /**
     * @dataProvider newEquipmentSuccessfulProvider
     * @param array $data
     */
    public function testNewEquipmentSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_EQUIPMENT_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_equipment', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_EQUIPMENT_LIST));

        $equipment = $em->getRepository(Equipment::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(Equipment::class, $equipment);

        $this->assertCheckEntityProps($equipment, $data);
    }

    /**
     * @return array
     */
    public function newEquipmentSuccessfulProvider(): array
    {
        return [
            [['label' => 'EquipmentTest']]
        ];
    }

    /**
     * @dataProvider newEquipmentNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewEquipmentNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_EQUIPMENT_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_equipment', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_equipment' . $fieldName, $tagName);

        $user = $em->getRepository(Equipment::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newEquipmentNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }

    /*
     *  Edit Equipment
     */

    /**
     * @throws EquipmentNotFoundException
     */
    public function testEditEquipmentUserNotAuthenticated()
    {
        $equipment = $this->getEquipment();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_EQUIPMENT_EDIT, ['id' => $equipment->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws EquipmentNotFoundException
     */
    public function testEditEquipmentWithAdminPermission()
    {
        $equipment = $this->getEquipment();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_EQUIPMENT_EDIT, ['id' => $equipment->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editEquipmentWithMissingRoleProvider
     * @param array $data
     * @throws EquipmentNotFoundException
     */
    public function testEditEquipmentWithMissingRole(array $data)
    {
        $equipment = $this->getEquipment();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_EQUIPMENT_EDIT, ['id' => $equipment->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editEquipmentWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_EQUIPMENT']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_EQUIPMENT_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_EQUIPMENT', 'ROLE_ADMIN_EQUIPMENT_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_EQUIPMENT']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_EQUIPMENT_UPDATE']],
        ];
    }

    public function testEditEquipmentWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_EQUIPMENT_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editEquipmentSuccessfulProvider
     * @param array $data
     */
    public function testEditEquipmentSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $equipment = new Equipment();
        $equipment->setLabel('Fake');

        $em->persist($equipment);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_EQUIPMENT_EDIT, ['id' => $equipment->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_equipment',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var Equipment $updatedEquipment */
        $updatedEquipment = $em->getRepository(Equipment::class)->find($equipment->getId());

        $this->assertCheckEntityProps($updatedEquipment, $data);
    }

    /**
     * @return array
     */
    public function editEquipmentSuccessfulProvider(): array
    {
        return [
            [['label' => 'EquipmentTest']]
        ];
    }

    /**
     * @dataProvider editEquipmentNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws EquipmentNotFoundException
     */
    public function testEditEquipmentNotValid(array $data, $fieldName, $tagName = null)
    {
        $equipment = $this->getEquipment();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_EQUIPMENT_EDIT, ['id' => $equipment->getId()]));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_equipment', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_equipment' . $fieldName, $tagName);
    }

    /**
     * @return array[]
     */
    public function editEquipmentNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }
}