<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\TwigBundle\CacheWarmer;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Environment;
use Twig\Error\Error;

/**
 * Generates the Twig cache for all templates.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TemplateCacheWarmer implements CacheWarmerInterface, ServiceSubscriberInterface
{
    private $container;
    private $twig;
    private $iterator;

    public function __construct(ContainerInterface $container, iterable $iterator)
    {
        // As this cache warmer is optional, dependencies should be lazy-loaded, that's why a container should be injected.
        $this->container = $container;
        $this->iterator = $iterator;
    }

    /**
     * {@inheritdoc}
<<<<<<< HEAD
=======
     *
     * @return string[] A list of template files to preload on PHP 7.4+
>>>>>>> ThomasN
     */
    public function warmUp(string $cacheDir)
    {
        if (null === $this->twig) {
            $this->twig = $this->container->get('twig');
        }

<<<<<<< HEAD
        foreach ($this->iterator as $template) {
            try {
                $this->twig->load($template);
=======
        $files = [];

        foreach ($this->iterator as $template) {
            try {
                $template = $this->twig->load($template);

                if (\is_callable([$template, 'unwrap'])) {
                    $files[] = (new \ReflectionClass($template->unwrap()))->getFileName();
                }
>>>>>>> ThomasN
            } catch (Error $e) {
                // problem during compilation, give up
                // might be a syntax error or a non-Twig template
            }
        }
<<<<<<< HEAD
=======

        return $files;
>>>>>>> ThomasN
    }

    /**
     * {@inheritdoc}
     */
    public function isOptional()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedServices()
    {
        return [
            'twig' => Environment::class,
        ];
    }
}
