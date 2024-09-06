<?php

namespace App\Auth0\Infrastructure;

use Auth0\SDK\API\Authentication;
use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use DateTimeImmutable;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use function dd;
use function dump;
use function json_decode;
use function setcookie;

/** @implements UserProviderInterface<Auth0User> */
final class Auth0UserProvider implements UserProviderInterface
{
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
        setcookie('idToken', $userData['idToken'], httponly: true);

        return new Auth0User(
            $userData['user']['email'],
            ['ROLE_USER'],
            (new DateTimeImmutable())->setTimestamp($userData['accessTokenExpiration']),
        );
    }
}