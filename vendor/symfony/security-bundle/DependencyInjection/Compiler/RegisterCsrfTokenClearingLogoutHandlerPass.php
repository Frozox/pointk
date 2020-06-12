<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\SecurityBundle\DependencyInjection\Compiler;

<<<<<<< HEAD
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Christian Flothmann <christian.flothmann@sensiolabs.de>
 */
class RegisterCsrfTokenClearingLogoutHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('security.logout_listener') || !$container->has('security.csrf.token_storage')) {
            return;
        }

        $csrfTokenStorage = $container->findDefinition('security.csrf.token_storage');
        $csrfTokenStorageClass = $container->getParameterBag()->resolveValue($csrfTokenStorage->getClass());

        if (!is_subclass_of($csrfTokenStorageClass, 'Symfony\Component\Security\Csrf\TokenStorage\ClearableTokenStorageInterface')) {
            return;
        }

        $container->register('security.logout.handler.csrf_token_clearing', 'Symfony\Component\Security\Http\Logout\CsrfTokenClearingLogoutHandler')
            ->addArgument(new Reference('security.csrf.token_storage'))
            ->setPublic(false);

        $container->findDefinition('security.logout_listener')->addMethodCall('addHandler', [new Reference('security.logout.handler.csrf_token_clearing')]);
=======
use Symfony\Component\DependencyInjection\ContainerBuilder;

trigger_deprecation('symfony/security-bundle', '5.1', 'The "%s" class is deprecated.', RegisterCsrfTokenClearingLogoutHandlerPass::class);

/**
 * @deprecated since symfony/security-bundle 5.1
 */
class RegisterCsrfTokenClearingLogoutHandlerPass extends RegisterCsrfFeaturesPass
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('security.csrf.token_storage')) {
            return;
        }

        $this->registerLogoutHandler($container);
>>>>>>> ThomasN
    }
}
