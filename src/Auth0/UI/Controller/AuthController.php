<?php

namespace App\Auth0\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Twig\Environment;

final class AuthController extends AbstractController
{
    use TargetPathTrait;

    public function __construct(
        public Environment $environment,
    )
    {
    }

    #[Route(path: '/callback', name: 'auth0_callback')]
    public function authenticated(Request $request): Response
    {
       return new Response();
    }

    #[Route(path: '/logout', name: 'auth0_logout')]
    public function logout(Request $request): Response
    {
        return new RedirectResponse('http://localhost/');
    }
}