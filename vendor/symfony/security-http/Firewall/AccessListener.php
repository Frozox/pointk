<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Security\Http\Firewall;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Http\AccessMapInterface;
use Symfony\Component\Security\Http\Event\LazyResponseEvent;

/**
 * AccessListener enforces access control rules.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class AccessListener extends AbstractListener
{
<<<<<<< HEAD
=======
    const PUBLIC_ACCESS = 'PUBLIC_ACCESS';

>>>>>>> ThomasN
    private $tokenStorage;
    private $accessDecisionManager;
    private $map;
    private $authManager;
<<<<<<< HEAD

    public function __construct(TokenStorageInterface $tokenStorage, AccessDecisionManagerInterface $accessDecisionManager, AccessMapInterface $map, AuthenticationManagerInterface $authManager)
=======
    private $exceptionOnNoToken;

    public function __construct(TokenStorageInterface $tokenStorage, AccessDecisionManagerInterface $accessDecisionManager, AccessMapInterface $map, AuthenticationManagerInterface $authManager, bool $exceptionOnNoToken = true)
>>>>>>> ThomasN
    {
        $this->tokenStorage = $tokenStorage;
        $this->accessDecisionManager = $accessDecisionManager;
        $this->map = $map;
        $this->authManager = $authManager;
<<<<<<< HEAD
=======
        $this->exceptionOnNoToken = $exceptionOnNoToken;
>>>>>>> ThomasN
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request): ?bool
    {
        [$attributes] = $this->map->getPatterns($request);
        $request->attributes->set('_access_control_attributes', $attributes);

<<<<<<< HEAD
        return $attributes && [AuthenticatedVoter::IS_AUTHENTICATED_ANONYMOUSLY] !== $attributes ? true : null;
=======
        return $attributes && ([AuthenticatedVoter::IS_AUTHENTICATED_ANONYMOUSLY] !== $attributes && [self::PUBLIC_ACCESS] !== $attributes) ? true : null;
>>>>>>> ThomasN
    }

    /**
     * Handles access authorization.
     *
     * @throws AccessDeniedException
<<<<<<< HEAD
     * @throws AuthenticationCredentialsNotFoundException
     */
    public function authenticate(RequestEvent $event)
    {
        if (!$event instanceof LazyResponseEvent && null === $token = $this->tokenStorage->getToken()) {
=======
     * @throws AuthenticationCredentialsNotFoundException when the token storage has no authentication token and $exceptionOnNoToken is set to true
     */
    public function authenticate(RequestEvent $event)
    {
        if (!$event instanceof LazyResponseEvent && null === ($token = $this->tokenStorage->getToken()) && $this->exceptionOnNoToken) {
>>>>>>> ThomasN
            throw new AuthenticationCredentialsNotFoundException('A Token was not found in the TokenStorage.');
        }

        $request = $event->getRequest();

        $attributes = $request->attributes->get('_access_control_attributes');
        $request->attributes->remove('_access_control_attributes');

        if (!$attributes || ([AuthenticatedVoter::IS_AUTHENTICATED_ANONYMOUSLY] === $attributes && $event instanceof LazyResponseEvent)) {
            return;
        }

<<<<<<< HEAD
        if ($event instanceof LazyResponseEvent && null === $token = $this->tokenStorage->getToken()) {
            throw new AuthenticationCredentialsNotFoundException('A Token was not found in the TokenStorage.');
=======
        if ($event instanceof LazyResponseEvent) {
            $token = $this->tokenStorage->getToken();
        }

        if (null === $token) {
            if ($this->exceptionOnNoToken) {
                throw new AuthenticationCredentialsNotFoundException('A Token was not found in the TokenStorage.');
            }

            if ([AuthenticatedVoter::IS_AUTHENTICATED_ANONYMOUSLY] === $attributes) {
                trigger_deprecation('symfony/security-http', '5.1', 'Using "IS_AUTHENTICATED_ANONYMOUSLY" in your access_control rules when using the authenticator Security system is deprecated, use "PUBLIC_ACCESS" instead.');

                return;
            }

            if ([self::PUBLIC_ACCESS] !== $attributes) {
                throw $this->createAccessDeniedException($request, $attributes);
            }
        }

        if ([self::PUBLIC_ACCESS] === $attributes) {
            return;
>>>>>>> ThomasN
        }

        if (!$token->isAuthenticated()) {
            $token = $this->authManager->authenticate($token);
            $this->tokenStorage->setToken($token);
        }

<<<<<<< HEAD
        $granted = false;
        foreach ($attributes as $key => $value) {
            if ($this->accessDecisionManager->decide($token, [$key => $value], $request)) {
                $granted = true;
                break;
            }
        }

        if (!$granted) {
            $exception = new AccessDeniedException();
            $exception->setAttributes($attributes);
            $exception->setSubject($request);

            throw $exception;
        }
=======
        if (!$this->accessDecisionManager->decide($token, $attributes, $request, true)) {
            throw $this->createAccessDeniedException($request, $attributes);
        }
    }

    private function createAccessDeniedException(Request $request, array $attributes)
    {
        $exception = new AccessDeniedException();
        $exception->setAttributes($attributes);
        $exception->setSubject($request);

        return $exception;
>>>>>>> ThomasN
    }
}
