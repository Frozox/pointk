<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Loader\Configurator;

<<<<<<< HEAD
use Symfony\Component\Routing\Route;
=======
>>>>>>> ThomasN
use Symfony\Component\Routing\RouteCollection;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ImportConfigurator
{
<<<<<<< HEAD
=======
    use Traits\HostTrait;
    use Traits\PrefixTrait;
>>>>>>> ThomasN
    use Traits\RouteTrait;

    private $parent;

    public function __construct(RouteCollection $parent, RouteCollection $route)
    {
        $this->parent = $parent;
        $this->route = $route;
    }

    public function __destruct()
    {
        $this->parent->addCollection($this->route);
    }

    /**
     * Sets the prefix to add to the path of all child routes.
     *
     * @param string|array $prefix the prefix, or the localized prefixes
     *
     * @return $this
     */
    final public function prefix($prefix, bool $trailingSlashOnRoot = true): self
    {
<<<<<<< HEAD
        if (!\is_array($prefix)) {
            $this->route->addPrefix($prefix);
            if (!$trailingSlashOnRoot) {
                $rootPath = (new Route(trim(trim($prefix), '/').'/'))->getPath();
                foreach ($this->route->all() as $route) {
                    if ($route->getPath() === $rootPath) {
                        $route->setPath(rtrim($rootPath, '/'));
                    }
                }
            }
        } else {
            foreach ($prefix as $locale => $localePrefix) {
                $prefix[$locale] = trim(trim($localePrefix), '/');
            }
            foreach ($this->route->all() as $name => $route) {
                if (null === $locale = $route->getDefault('_locale')) {
                    $this->route->remove($name);
                    foreach ($prefix as $locale => $localePrefix) {
                        $localizedRoute = clone $route;
                        $localizedRoute->setDefault('_locale', $locale);
                        $localizedRoute->setDefault('_canonical_route', $name);
                        $localizedRoute->setPath($localePrefix.(!$trailingSlashOnRoot && '/' === $route->getPath() ? '' : $route->getPath()));
                        $this->route->add($name.'.'.$locale, $localizedRoute);
                    }
                } elseif (!isset($prefix[$locale])) {
                    throw new \InvalidArgumentException(sprintf('Route "%s" with locale "%s" is missing a corresponding prefix in its parent collection.', $name, $locale));
                } else {
                    $route->setPath($prefix[$locale].(!$trailingSlashOnRoot && '/' === $route->getPath() ? '' : $route->getPath()));
                    $this->route->add($name, $route);
                }
            }
        }
=======
        $this->addPrefix($this->route, $prefix, $trailingSlashOnRoot);
>>>>>>> ThomasN

        return $this;
    }

    /**
     * Sets the prefix to add to the name of all child routes.
     *
     * @return $this
     */
    final public function namePrefix(string $namePrefix): self
    {
        $this->route->addNamePrefix($namePrefix);

        return $this;
    }
<<<<<<< HEAD
=======

    /**
     * Sets the host to use for all child routes.
     *
     * @param string|array $host the host, or the localized hosts
     *
     * @return $this
     */
    final public function host($host): self
    {
        $this->addHost($this->route, $host);

        return $this;
    }
>>>>>>> ThomasN
}
