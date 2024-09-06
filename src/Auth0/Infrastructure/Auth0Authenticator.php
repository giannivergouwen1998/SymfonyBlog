<?php

namespace App\Auth0\Infrastructure;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Auth0\SDK\Exception\Auth0Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use function dd;
use function dump;
use function json_encode;

final class Auth0Authenticator extends AbstractAuthenticator
{
    use TargetPathTrait;

    private Auth0 $auth0;

    public function __construct(
        private readonly SdkConfiguration $configuration,
    )
    {
        $this->auth0 = new Auth0($this->configuration);
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'auth0_callback';
    }

    public function authenticate(Request $request): Passport
    {
        try {
            $this->auth0->exchange();
        }catch (Auth0Exception $exception)
        {
            throw new AuthenticationException('Authentication failed', previous: $exception);
        }

        $userData = $this->auth0->getCredentials();

        return new SelfValidatingPassport(
            new UserBadge(json_encode($userData))
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $path = $this->getTargetPath($request->getSession(), 'main');

        return new RedirectResponse($path ?? '/');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response(
            $exception->getMessage()
        );
    }
}