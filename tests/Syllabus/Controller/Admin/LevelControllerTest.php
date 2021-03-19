<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Level;
use App\Syllabus\Entity\Structure;
use App\Syllabus\Exception\LevelNotFoundException;
use App\Syllabus\Exception\StructureNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LevelControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class LevelControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Level List
     */
    
    public function testLevelListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_LEVEL_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testLevelListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_LEVEL_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider levelListWithMissingRoleProvider
     * @param array $data
     */
    public function testLevelListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LEVEL_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function levelListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LEVEL']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LEVEL_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_LEVEL', 'ROLE_ADMIN_LEVEL_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_LEVEL']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_LEVEL_LIST']],
        ];
    }

    /*
     *  New Level
     */

    public function testLevelNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_LEVEL_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testLevelNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_LEVEL_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider levelNewWithMissingRoleProvider
     * @param array $data
     */
    public function testLevelNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LEVEL_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function levelNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LEVEL']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LEVEL_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_LEVEL', 'ROLE_ADMIN_LEVEL_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_LEVEL']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_LEVEL_CREATE']],
        ];
    }

    /**
     * @dataProvider newLevelSuccessfulProvider
     * @param array $data
     */
    public function testNewLevelSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LEVEL_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_level', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_LEVEL_LIST));

        $campus = $em->getRepository(Level::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(Level::class, $campus);

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
    public function newLevelSuccessfulProvider(): array
    {
        $structure = $this->getStructure();
        return [
            [['label' => 'LevelTest']],
            [['label' => 'LevelTest', 'structures' => $structure->getId()]]
        ];
    }

    /**
     * @dataProvider newLevelNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewLevelNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LEVEL_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_level', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_level' . $fieldName, $tagName);

        $user = $em->getRepository(Level::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newLevelNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }

    /*
     *  Edit Campus
     */

    /**
     * @throws LevelNotFoundException
     */
    public function testEditLevelUserNotAuthenticated()
    {
        $level = $this->getLevel();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_LEVEL_EDIT, ['id' => $level->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws LevelNotFoundException
     */
    public function testEditLevelWithAdminPermission()
    {
        $level = $this->getLevel();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_LEVEL_EDIT, ['id' => $level->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editLevelWithMissingRoleProvider
     * @param array $data
     * @throws LevelNotFoundException
     */
    public function testEditLevelWithMissingRole(array $data)
    {
        $level = $this->getLevel();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LEVEL_EDIT, ['id' => $level->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editLevelWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LEVEL']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LEVEL_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_LEVEL', 'ROLE_ADMIN_LEVEL_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_LEVEL']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_LEVEL_UPDATE']],
        ];
    }

    public function testEditLevelWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_LEVEL_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editLevelSuccessfulProvider
     * @param array $data
     */
    public function testEditLevelSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $level = new Level();
        $level->setLabel('Fake');

        $em->persist($level);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_LEVEL_EDIT, ['id' => $level->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_level',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var Level $updatedLevel */
        $updatedLevel = $em->getRepository(Level::class)->find($level->getId());

        $this->assertCheckEntityProps($updatedLevel, $data);
    }

    /**
     * @return array
     */
    public function editLevelSuccessfulProvider(): array
    {
        return [
            [['label' => 'LevelTest']]
        ];
    }

    /**
     * @dataProvider editLevelNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws LevelNotFoundException
     */
    public function testEditLevelNotValid(array $data, $fieldName, $tagName = null)
    {
        $level = $this->getLevel();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LEVEL_EDIT, ['id' => $level->getId()]));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_level', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_level' . $fieldName, $tagName);
    }

    /**
     * @return array[]
     */
    public function editLevelNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }
}