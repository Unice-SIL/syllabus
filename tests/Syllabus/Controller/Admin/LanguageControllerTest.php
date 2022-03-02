<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Language;
use App\Syllabus\Exception\LanguageNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LanguageControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class LanguageControllerTest extends AbstractAdminControllerTest
{
    /*
     *  Language List
     */
    
    public function testLanguageListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_LANGUAGE_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testLanguageListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_LANGUAGE_LIST);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider languageListWithMissingRoleProvider
     * @param array $data
     */
    public function testLanguageListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LANGUAGE_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function languageListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LANGUAGE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LANGUAGE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_LANGUAGE', 'ROLE_ADMIN_LANGUAGE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_LANGUAGE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_LANGUAGE_LIST']],
        ];
    }
    
    /**
     * @throws LanguageNotFoundException
     */
    public function testLanguageFilter()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_LANGUAGE_LIST, [
            'language_filter' => [
                'label' => $this->getLanguage()->getLabel()
            ]
        ]);
        $this->assertResponseIsSuccessful();
    }

    /*
     *  New Language
     */

    public function testLanguageNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_LANGUAGE_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testLanguageNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_LANGUAGE_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider languageNewWithMissingRoleProvider
     * @param array $data
     */
    public function testLanguageNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LANGUAGE_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function languageNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LANGUAGE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LANGUAGE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_LANGUAGE', 'ROLE_ADMIN_LANGUAGE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_LANGUAGE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_LANGUAGE_CREATE']],
        ];
    }

    /**
     * @dataProvider newLanguageSuccessfulProvider
     * @param array $data
     */
    public function testNewLanguageSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LANGUAGE_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_language', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_LANGUAGE_LIST));

        $language = $em->getRepository(Language::class)->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertInstanceOf(Language::class, $language);

        $this->assertCheckEntityProps($language, $data);
    }

    /**
     * @return array
     */
    public function newLanguageSuccessfulProvider(): array
    {
        return [
            [['label' => 'LanguageTest']]
        ];
    }

    /**
     * @dataProvider newLanguageNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param $tagName
     */
    public function testNewLanguageNotValid(array $data, $fieldName, $tagName = null)
    {
        $em = $this->getEntityManager();
        $this->login();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LANGUAGE_NEW));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_language', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_language' . $fieldName, $tagName);

        $user = $em->getRepository(Language::class)
            ->findOneBy(['label' => $data['label'] ?? '']);

        $this->assertNull($user);
    }

    /**
     * @return array[]
     */
    public function newLanguageNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }

    /*
     *  Edit Language
     */

    /**
     * @throws LanguageNotFoundException
     */
    public function testEditLanguageUserNotAuthenticated()
    {
        $language = $this->getLanguage();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_LANGUAGE_EDIT, ['id' => $language->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws LanguageNotFoundException
     */
    public function testEditLanguageWithAdminPermission()
    {
        $language = $this->getLanguage();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_LANGUAGE_EDIT, ['id' => $language->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider editLanguageWithMissingRoleProvider
     * @param array $data
     * @throws LanguageNotFoundException
     */
    public function testEditLanguageWithMissingRole(array $data)
    {
        $language = $this->getLanguage();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LANGUAGE_EDIT, ['id' => $language->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function editLanguageWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LANGUAGE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_LANGUAGE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_LANGUAGE', 'ROLE_ADMIN_LANGUAGE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_LANGUAGE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_LANGUAGE_UPDATE']],
        ];
    }

    public function testEditLanguageWithWrongId()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_LANGUAGE_EDIT, ['id' => 'fakeId']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider editLanguageSuccessfulProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testEditLanguageSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();

        $language = new Language();
        $language->setLabel('Fake');

        $em->persist($language);
        $em->flush();

        $crawler = $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_ADMIN_LANGUAGE_EDIT, ['id' => $language->getId()])
        );

        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'appbundle_language',
            $data
        );

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        /** @var Language $updatedLanguage */
        $updatedLanguage = $em->getRepository(Language::class)->find($language->getId());

        $this->assertCheckEntityProps($updatedLanguage, $data);
    }

    /**
     * @return array
     */
    public function editLanguageSuccessfulProvider(): array
    {
        return [
            [['label' => 'LanguageTest']]
        ];
    }

    /**
     * @dataProvider editLanguageNotValidProvider
     * @param array $data
     * @param $fieldName
     * @param null $tagName
     * @throws LanguageNotFoundException
     */
    public function testEditLanguageNotValid(array $data, $fieldName, $tagName = null)
    {
        $language = $this->getLanguage();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LANGUAGE_EDIT, ['id' => $language->getId()]));
        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'appbundle_language', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_language' . $fieldName, $tagName);
    }

    /**
     * @return array[]
     */
    public function editLanguageNotValidProvider(): array
    {
        return [
            [['label' => null], '[label]']
        ];
    }
}