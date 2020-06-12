<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\RouteCollection;

/**
 * PhpFileLoader loads routes from a PHP file.
 *
 * The file must return a RouteCollection instance.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
=======
 * @author Nicolas grekas <p@tchwork.com>
 * @author Jules Pietri <jules@heahprod.com>
>>>>>>> ThomasN
 */
class PhpFileLoader extends FileLoader
{
    /**
     * Loads a PHP file.
     *
     * @param string      $file A PHP file path
     * @param string|null $type The resource type
     *
     * @return RouteCollection A RouteCollection instance
     */
    public function load($file, string $type = null)
    {
        $path = $this->locator->locate($file);
        $this->setCurrentDir(\dirname($path));

        // the closure forbids access to the private scope in the included file
        $loader = $this;
        $load = \Closure::bind(static function ($file) use ($loader) {
            return include $file;
        }, null, ProtectedPhpFileLoader::class);

        $result = $load($path);

        if (\is_object($result) && \is_callable($result)) {
<<<<<<< HEAD
            $collection = new RouteCollection();
            $result(new RoutingConfigurator($collection, $this, $path, $file));
=======
            $collection = $this->callConfigurator($result, $path, $file);
>>>>>>> ThomasN
        } else {
            $collection = $result;
        }

        $collection->addResource(new FileResource($path));

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, string $type = null)
    {
        return \is_string($resource) && 'php' === pathinfo($resource, PATHINFO_EXTENSION) && (!$type || 'php' === $type);
    }
<<<<<<< HEAD
=======

    protected function callConfigurator(callable $result, string $path, string $file): RouteCollection
    {
        $collection = new RouteCollection();

        $result(new RoutingConfigurator($collection, $this, $path, $file));

        return $collection;
    }
>>>>>>> ThomasN
}

/**
 * @internal
 */
final class ProtectedPhpFileLoader extends PhpFileLoader
{
}
