<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Serializer\Mapping\Factory;

use Psr\Cache\CacheItemPoolInterface;

/**
 * Caches metadata using a PSR-6 implementation.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class CacheClassMetadataFactory implements ClassMetadataFactoryInterface
{
    use ClassResolverTrait;

    /**
     * @var ClassMetadataFactoryInterface
     */
    private $decorated;

    /**
     * @var CacheItemPoolInterface
     */
    private $cacheItemPool;

<<<<<<< HEAD
=======
    private $loadedClasses = [];

>>>>>>> ThomasN
    public function __construct(ClassMetadataFactoryInterface $decorated, CacheItemPoolInterface $cacheItemPool)
    {
        $this->decorated = $decorated;
        $this->cacheItemPool = $cacheItemPool;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadataFor($value)
    {
        $class = $this->getClass($value);
<<<<<<< HEAD
=======

        if (isset($this->loadedClasses[$class])) {
            return $this->loadedClasses[$class];
        }

>>>>>>> ThomasN
        // Key cannot contain backslashes according to PSR-6
        $key = strtr($class, '\\', '_');

        $item = $this->cacheItemPool->getItem($key);
        if ($item->isHit()) {
<<<<<<< HEAD
            return $item->get();
=======
            return $this->loadedClasses[$class] = $item->get();
>>>>>>> ThomasN
        }

        $metadata = $this->decorated->getMetadataFor($value);
        $this->cacheItemPool->save($item->set($metadata));

<<<<<<< HEAD
        return $metadata;
=======
        return $this->loadedClasses[$class] = $metadata;
>>>>>>> ThomasN
    }

    /**
     * {@inheritdoc}
     */
    public function hasMetadataFor($value)
    {
        return $this->decorated->hasMetadataFor($value);
    }
}
