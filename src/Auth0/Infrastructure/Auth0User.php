<?php

namespace App\Auth0\Infrastructure;

use DateTimeImmutable;
use LogicException;
use Symfony\Component\Security\Core\User\UserInterface;

final class Auth0User implements UserInterface
{

   /** @param array<string> $roles */
   public function __construct(
        private readonly string $email,
        private readonly array $roles,
        public readonly DateTimeImmutable $accessTokenExpirationTime,
   )
   {
   }

    public function getRoles(): array
    {
        if(empty($this->roles))
        {
            return ['ROLE_USER'];
        }

        return $this->roles;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}