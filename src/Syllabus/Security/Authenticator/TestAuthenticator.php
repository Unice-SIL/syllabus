<?php

namespace App\Syllabus\Security\Authenticator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * Class TestAuthAuthenticator
 * @package App\Syllabus\Security
 */
class TestAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * TestAuthAuthenticator constructor.
     * @param array $config
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        array $config = array(),
        TokenStorageInterface $tokenStorage)
    {
        $this->config = $config;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request){
        if (!empty($this->tokenStorage->getToken()) && $this->tokenStorage->getToken()->getUser()) {
            return false;
        }
        return true;
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return RedirectResponse
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($request->getUri());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getCredentials(Request $request)
    {
        if(!array_key_exists('current', $this->config)){
            throw new UsernameNotFoundException("Username not found in test authenticator_configuration");
        }
        $username = $this->config['current'];
        if(!array_key_exists($username, $this->config['users'])){
            throw new UsernameNotFoundException(sprintf("User %s not found in users configured for test_authenticator.", $username));
        }
        $credentials = $this->config['users'][$username];
        $credentials['username'] = $username;
        return $credentials;
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if(!array_key_exists('username', $credentials)){
            throw new UsernameNotFoundException("Username not found in credentials");
        }
        return $userProvider->loadUserByUsername($credentials['username']);
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(array('message' => $exception->getMessageKey()), Response::HTTP_FORBIDDEN);
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }

}