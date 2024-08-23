<?php

namespace App\Auth0\Infrastructure;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use function dd;

final class Auth0Logout implements EventSubscriberInterface
{
    private Auth0 $auth0;

    public function __construct(
        private SdkConfiguration $configuration,
    )
    {
        $this->auth0 = new Auth0($this->configuration);
    }

    public function onLogout(LogoutEvent $event): void
    {
        $event->setResponse(
            new RedirectResponse(
                $this->auth0->logout('https://google.com')
            )
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogout'
        ];
    }
}