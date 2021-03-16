<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Year;
use App\Syllabus\Exception\YearNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class YearControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class YearControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Year List
     */

    public function testYearListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_YEAR_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testYearListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_YEAR_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider yearListWithMissingRoleProvider
     * @param array $data
     */
    public function testYearListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_YEAR_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function yearListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_YEAR']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_YEAR_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_YEAR', 'ROLE_ADMIN_YEAR_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_YEAR']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_YEAR_LIST']],
        ];
    }


    /*
     *  New Year
     */

    public function testYearNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_MODE_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testYearNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_MODE_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider yearNewWithMissingRoleProvider
     * @param array $data
     */
    public function testYearNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function yearNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_YEAR']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_YEAR_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_YEAR', 'ROLE_ADMIN_YEAR_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_YEAR']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_YEAR_CREATE']],
        ];
    }

    /**
     * @dataProvider newYearSuccessfulProvider
     * @param array $data
     */
    public function testNewYearSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_YEAR_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_year', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_YEAR_LIST));

        $activityMode = $em->getRepository(Year::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(Year::class, $activityMode);

        $this->assertCheckEntityProps($activityMode, $data);
    }

    /**
     * @return array
     */
    public function newYearSuccessfulProvider(): array
    {
        return [
            [
                ['id' => '2021', 'label' => '2021-2022']
            ]
        ];
    }


    /**
     * @dataProvider newYearNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewYearNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_YEAR_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_year', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_year' . $fieldName, $tagName);

        $user = $em->getRepository(Year::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newYearNotValidProvider(): array
    {
        return [
            [['id' => '2021', 'label' => null], '[label]'],
            [['id' => null, 'label' => '2021-2022'], '[id]'],
            [['id' => '424242', 'label' => '2021-2022'], '[id]'],
            [['id' => 'fake', 'label' => '2021-2022'], '[id]'],
        ];
    }

    /*
     *  Edit Year
     */

    /**
     * @throws YearNotFoundException
     */
    public function testEditYearUserNotAuthenticated()
    {
        $year = $this->getYear();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_YEAR_EDIT, ['id' => $year->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws YearNotFoundException
     */
    public function testEditYearWithAdminPermission()
    {
        $year = $this->getYear();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_YEAR_EDIT, ['id' => $year->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editYearWithMissingRoleProvider
     * @param array $data
     * @throws YearNotFoundException
     */
    public function testEditYearWithMissingRole(array $data)
    {
        $year = $this->getYear();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_YEAR_EDIT, ['id' => $year->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editYearWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_YEAR']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_YEAR_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_YEAR', 'ROLE_ADMIN_YEAR_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_YEAR']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_YEAR_UPDATE']],
        ];
    }

    public function testEditYearWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_YEAR_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editYearSuccessfulProvider
     * @param array $data
     */
    public function testEditYearSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $year = new Year();
        $year->setId('2000')
            ->setLabel('Fake');

        $em->persist($year);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_YEAR_EDIT, ['id' => $year->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_year',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var Year $updatedYear */
        $updatedYear = $em->getRepository(Year::class)->find($year->getId());

        $this->assertCheckEntityProps($updatedYear, $data);
    }

    /**
     * @return array
     */
    public function editYearSuccessfulProvider(): array
    {
        return [
            [
                ['label' => '2021-2022']
            ]
        ];
    }

    /**
     * @dataProvider editYearNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws YearNotFoundException
     */
    public function testEditYearNotValid(array $data, $fieldName, $tagName = null)
    {
        $year = $this->getYear();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_YEAR_EDIT, ['id' => $year->getId()]));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_year', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_year' . $fieldName, $tagName);
    }

    /**
     * @return array[]
     */
    public function editYearNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }
}