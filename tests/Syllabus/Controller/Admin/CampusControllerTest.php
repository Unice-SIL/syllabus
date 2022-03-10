<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Campus;
use App\Syllabus\Exception\CampusNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CampusControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CampusControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Campus List
     */

    public function testCampusListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_CAMPUS_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCampusListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_CAMPUS_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider campusListWithMissingRoleProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testCampusListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CAMPUS_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function campusListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CAMPUS']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CAMPUS_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_CAMPUS', 'ROLE_ADMIN_CAMPUS_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_CAMPUS']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_CAMPUS_LIST']],
        ];
    }

    /**
     * @throws CampusNotFoundException
     */
    public function testCampusFilter()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_CAMPUS_LIST, [
            'campus_filter' => [
                'label' => $this->getCampus()->getLabel()
            ]
        ]);
        $this->assertResponseIsSuccessful();
    }

    /*
     *  New Campus
     */

    public function testCampusNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_CAMPUS_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCampusNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_CAMPUS_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider campusNewWithMissingRoleProvider
     * @param array $data
     */
    public function testCampusNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CAMPUS_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function campusNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CAMPUS']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CAMPUS_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_CAMPUS', 'ROLE_ADMIN_CAMPUS_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_CAMPUS']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_CAMPUS_CREATE']],
        ];
    }

    /**
     * @dataProvider newCampusSuccessfulProvider
     * @param array $data
     */
    public function testNewCampusSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CAMPUS_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_campus', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_CAMPUS_LIST));

        $campus = $em->getRepository(Campus::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(Campus::class, $campus);

        $this->assertCheckEntityProps($campus, $data);
    }

    /**
     * @return array
     */
    public function newCampusSuccessfulProvider(): array
    {
        return [
            [['label' => 'CampusTest']],
            [['label' => 'CampusTest', 'grp' => 'groupTest']]
        ];
    }

    /**
     * @dataProvider newCampusNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewCampusNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CAMPUS_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_campus', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_campus' . $fieldName, $tagName);

        $user = $em->getRepository(Campus::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newCampusNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }

    /*
     *  Edit Campus
     */

    /**
     * @throws CampusNotFoundException
     */
    public function testEditCampusUserNotAuthenticated()
    {
        $campus = $this->getCampus();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_CAMPUS_EDIT, ['id' => $campus->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CampusNotFoundException
     */
    public function testEditCampusWithAdminPermission()
    {
        $campus = $this->getCampus();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_CAMPUS_EDIT, ['id' => $campus->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editCampusWithMissingRoleProvider
     * @param array $data
     * @throws CampusNotFoundException
     */
    public function testEditCampusWithMissingRole(array $data)
    {
        $campus = $this->getCampus();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CAMPUS_EDIT, ['id' => $campus->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editCampusWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CAMPUS']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_CAMPUS_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_CAMPUS', 'ROLE_ADMIN_CAMPUS_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_CAMPUS']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_CAMPUS_UPDATE']],
        ];
    }

    public function testEditCampusWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_CAMPUS_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editCampusSuccessfulProvider
     * @param array $data
     */
    public function testEditCampusSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $campus = new Campus();
        $campus->setLabel('Fake');

        $em->persist($campus);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_CAMPUS_EDIT, ['id' => $campus->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_campus',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var Campus $updatedCampus */
        $updatedCampus = $em->getRepository(Campus::class)->find($campus->getId());

        $this->assertCheckEntityProps($updatedCampus, $data);
    }

    /**
     * @return array
     */
    public function editCampusSuccessfulProvider(): array
    {
        return [
            [['label' => 'CampusTest']]
        ];
    }

    /**
     * @dataProvider editCampusNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws CampusNotFoundException
     */
    public function testEditCampusNotValid(array $data, $fieldName, $tagName = null)
    {
        $campus = $this->getCampus();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CAMPUS_EDIT, ['id' => $campus->getId()]));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_campus', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_campus' . $fieldName, $tagName);
    }

    /**
     * @return array[]
     */
    public function editCampusNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }

    /**
     * @throws CampusNotFoundException
     * @throws UserNotFoundException
     */
    public function testAutocompleteS2()
    {
        $campus = $this->getCampus();
        $responseData = $this->getAutocompleteJson(
            $this->generateUrl(self::ROUTE_ADMIN_CAMPUS_AUTOCOMPLETE),
            ['c' => $campus->getLabel()]
        );
        $this->assertEquals($campus->getId(), current($responseData)['id']);
    }
}