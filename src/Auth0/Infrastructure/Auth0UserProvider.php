<?php

namespace App\Auth0\Infrastructure;

use Auth0\SDK\API\Authentication;
use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use function json_decode;

/** @implements UserProviderInterface<Auth0User> */
final class Auth0UserProvider implements UserProviderInterface
{
    private Authentication $authentication;
    private Auth0 $auth0;

    public function __construct(
        public SdkConfiguration $configuration,
    )
    {
        $this->authentication = new Authentication($this->configuration);
        $this->auth0 = new Auth0($this->configuration);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if(!$user instanceof Auth0User)
        {
            throw new UnsupportedUserException();
        }

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return Auth0User::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $userData = json_decode($identifier, true);
        $this->auth0->getUser();
        $response = $this->authentication->clientCredentials();

        $managementTokenResponse = json_decode($response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
        $this->configuration->setManagementToken($managementTokenResponse->access_token);

//        return new Auth0User(
//            $userData['user']['sub'],
//            $userData['user']['email'] ?? null,
//            ['ROLE_USER'],
//            $userData['accessToken'] ?? null,
//            $userData['accessTokenExpired'] ?? null,
//        );

        return new Auth0User(
            '123',
            'g@g.nl',
            ['ROLE_USER'],
            $managementTokenResponse->access_token,
            false
        );
    }
}