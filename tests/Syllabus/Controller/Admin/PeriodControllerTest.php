<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Period;
use App\Syllabus\Entity\Structure;
use App\Syllabus\Exception\PeriodNotFoundException;
use App\Syllabus\Exception\StructureNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PeriodControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class PeriodControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Period List
     */
    
    public function testPeriodListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_PERIOD_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testPeriodListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_PERIOD_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider periodListWithMissingRoleProvider
     * @param array $data
     */
    public function testPeriodListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_PERIOD_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function periodListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_PERIOD']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_PERIOD_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_PERIOD', 'ROLE_ADMIN_PERIOD_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_PERIOD']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_PERIOD_LIST']],
        ];
    }

    /*
     *  New Period
     */

    public function testPeriodNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_PERIOD_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testPeriodNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_PERIOD_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider periodNewWithMissingRoleProvider
     * @param array $data
     */
    public function testPeriodNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_PERIOD_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function periodNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_PERIOD']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_PERIOD_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_PERIOD', 'ROLE_ADMIN_PERIOD_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_PERIOD']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_PERIOD_CREATE']],
        ];
    }

    /**
     * @dataProvider newPeriodSuccessfulProvider
     * @param array $data
     */
    public function testNewPeriodSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_PERIOD_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_period', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_PERIOD_LIST));

        $campus = $em->getRepository(Period::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(Period::class, $campus);

        $this->assertCheckEntityProps($campus, $data, [
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
    public function newPeriodSuccessfulProvider(): array
    {
        $structure = $this->getStructure();
        return [
            [['label' => 'PeriodTest']],
            [['label' => 'PeriodTest', 'structures' => $structure->getId()]]
        ];
    }

    /**
     * @dataProvider newPeriodNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewPeriodNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_PERIOD_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_period', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_period' . $fieldName, $tagName);

        $user = $em->getRepository(Period::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newPeriodNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }

    /*
     *  Edit Campus
     */

    /**
     * @throws PeriodNotFoundException
     */
    public function testEditPeriodUserNotAuthenticated()
    {
        $period = $this->getPeriod();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_PERIOD_EDIT, ['id' => $period->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws PeriodNotFoundException
     */
    public function testEditPeriodWithAdminPermission()
    {
        $period = $this->getPeriod();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_PERIOD_EDIT, ['id' => $period->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editPeriodWithMissingRoleProvider
     * @param array $data
     * @throws PeriodNotFoundException
     */
    public function testEditPeriodWithMissingRole(array $data)
    {
        $period = $this->getPeriod();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_PERIOD_EDIT, ['id' => $period->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editPeriodWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_PERIOD']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_PERIOD_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_PERIOD', 'ROLE_ADMIN_PERIOD_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_PERIOD']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_PERIOD_UPDATE']],
        ];
    }

    public function testEditPeriodWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_PERIOD_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editPeriodSuccessfulProvider
     * @param array $data
     */
    public function testEditPeriodSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $period = new Period();
        $period->setLabel('Fake');

        $em->persist($period);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_PERIOD_EDIT, ['id' => $period->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_period',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var Period $updatedPeriod */
        $updatedPeriod = $em->getRepository(Period::class)->find($period->getId());

        $this->assertCheckEntityProps($updatedPeriod, $data);
    }

    /**
     * @return array
     */
    public function editPeriodSuccessfulProvider(): array
    {
        return [
            [['label' => 'PeriodTest']]
        ];
    }

    /**
     * @dataProvider editPeriodNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws PeriodNotFoundException
     */
    public function testEditPeriodNotValid(array $data, $fieldName, $tagName = null)
    {
        $period = $this->getPeriod();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_PERIOD_EDIT, ['id' => $period->getId()]));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_period', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_period' . $fieldName, $tagName);
    }

    /**
     * @return array[]
     */
    public function editPeriodNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }
}