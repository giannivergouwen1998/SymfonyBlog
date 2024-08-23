<?php

namespace App\Auth0\UI\Controller;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use function dd;


final class Auth0EntryPoint implements AuthenticationEntryPointInterface
{
    use TargetPathTrait;

    public const FIREWALL_NAME = 'main';

    private Auth0 $auth0;

    public function __construct(
        private SdkConfiguration $configuration,
    )
    {
        $this->auth0 = new Auth0($this->configuration);
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        $this->saveTargetPath(
            $request->getSession(),
            self::FIREWALL_NAME,
            $request->getRequestUri(),
        );

        return new RedirectResponse($this->auth0->login());
    }
}