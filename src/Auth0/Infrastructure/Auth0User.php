<?php

namespace App\Auth0\Infrastructure;

use Symfony\Component\Security\Core\User\UserInterface;

final class Auth0User implements UserInterface
{

   /** @param array<string> $roles */
   public function __construct(
        private readonly string $userId,
        private readonly ?string $email,
        private readonly array $roles,
        private ?string $accessToken,
        private ?bool $accessTokenExpired,
   )
   {
   }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getUserId(): string
    {
        return $this->userId;
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

    public function setAccessTokenExpired(?bool $accessTokenExpired): void
    {
        $this->accessTokenExpired = $accessTokenExpired;
    }

    public function getAccessTokenExpired(): ?bool
    {
        return $this->accessTokenExpired;
    }

    public function getUserIdentifier(): string
    {
        return $this->userId;
    }

    public function setAccessToken(?string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }
}