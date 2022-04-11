<?php

namespace Tests\Syllabus\Controller\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Syllabus\Entity\User;
use App\Syllabus\Fixture\CourseFixture;
use App\Syllabus\Fixture\UserFixture;
use App\Syllabus\Fixture\YearFixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

abstract class AbstractApiTest extends ApiTestCase
{
    public const API_DUPLICATION_COURSE_INFO = 'app.course_infos.api.duplicate';
    public const AUTHENTICATION_TOKEN = '/api/login_check';

    public const COURSE_CODE1 = CourseFixture::COURSE_1;
    public const COURSE_CODE2 = CourseFixture::COURSE_2;
    public const COURSE_YEAR = YearFixture::YEAR_2018;

    private $token;

    /**
     * @var User|null
     */
    private $user = null;

    /**
     * @var Client|null
     */
    private $client = null;

    public function setUp(): void
    {
        self::bootKernel();
    }

    /**
     * @param string $route
     * @param array $parameters
     * @return mixed
     */
    protected function generateUrl(string $route, array $parameters = [])
    {
        return $this->client()->getContainer()->get('router')->generate($route, $parameters);
    }

    /**
     * @return Client|null
     */
    public function client($token = null)
    {
        $options = [];
        if ($token) {
            $options['headers']['authorization'] = 'Bearer ' . $token;
        }

        self::ensureKernelShutdown();
        $this->client = static::createClient([], $options);

        return $this->client;
    }

    protected function requestApiUrl(
        string $url,
        string $method = Request::METHOD_GET,
        $body = null,
        $json = null,
        $token = null
    ) {
        $token = $token ?: $this->getToken();
        return $this->client($token)->request(
            $method,
            $url,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-type' => 'application/json'
                ],
                'body' => $body,
                'json' => $json
            ]
        );
    }

    protected function getToken($body = []): string
    {
        if ($this->token) {
            return $this->token;
        }

        $response = static::createClient()->request(
            'POST',
            self::AUTHENTICATION_TOKEN,
            [
                'json' => $body ?: [
                    'username' => UserFixture::USER_1,
                    'password' => UserFixture::PASSWORD_TEST,
                ]
            ]
        );

        $this->assertResponseIsSuccessful();
        $data = json_decode($response->getContent());
        $this->token = $data->token;

        return $this->token;
    }

    /**
     * @param string|null $name
     * @return ObjectManager
     */
    protected function getEntityManager(string $name = null): ObjectManager
    {
        return $this->client()->getContainer()->get('doctrine')->getManager($name);
    }

    /**
     * @param string $username
     * @param bool $refresh
     * @return User
     */
    public function getUser(string $username = UserFixture::USER_1, bool $refresh = false): User
    {
        if (!$this->user instanceof User || $this->user->getUsername() !== $username || !$refresh) {
            $this->user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['username' => $username]);
        }

        if (!$this->user instanceof User) {
            throw new UserNotFoundException();
        }

        return $this->user;
    }
}
