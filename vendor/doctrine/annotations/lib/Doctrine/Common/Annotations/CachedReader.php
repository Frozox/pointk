<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\Common\Annotations;

use Doctrine\Common\Cache\Cache;
use ReflectionClass;

/**
 * A cache aware annotation reader.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
final class CachedReader implements Reader
{
    /**
     * @var Reader
     */
    private $delegate;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var boolean
     */
    private $debug;

    /**
     * @var array
     */
    private $loadedAnnotations = [];

    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param Reader $reader
     * @param Cache  $cache
     * @param bool   $debug
=======
     * @var int[]
     */
    private $loadedFilemtimes = [];

    /**
     * @param bool $debug
>>>>>>> ThomasN
     */
    public function __construct(Reader $reader, Cache $cache, $debug = false)
    {
        $this->delegate = $reader;
        $this->cache = $cache;
        $this->debug = (boolean) $debug;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassAnnotations(ReflectionClass $class)
    {
        $cacheKey = $class->getName();

        if (isset($this->loadedAnnotations[$cacheKey])) {
            return $this->loadedAnnotations[$cacheKey];
        }

        if (false === ($annots = $this->fetchFromCache($cacheKey, $class))) {
            $annots = $this->delegate->getClassAnnotations($class);
            $this->saveToCache($cacheKey, $annots);
        }

        return $this->loadedAnnotations[$cacheKey] = $annots;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassAnnotation(ReflectionClass $class, $annotationName)
    {
        foreach ($this->getClassAnnotations($class) as $annot) {
            if ($annot instanceof $annotationName) {
                return $annot;
            }
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAnnotations(\ReflectionProperty $property)
    {
        $class = $property->getDeclaringClass();
        $cacheKey = $class->getName().'$'.$property->getName();

        if (isset($this->loadedAnnotations[$cacheKey])) {
            return $this->loadedAnnotations[$cacheKey];
        }

        if (false === ($annots = $this->fetchFromCache($cacheKey, $class))) {
            $annots = $this->delegate->getPropertyAnnotations($property);
            $this->saveToCache($cacheKey, $annots);
        }

        return $this->loadedAnnotations[$cacheKey] = $annots;
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAnnotation(\ReflectionProperty $property, $annotationName)
    {
        foreach ($this->getPropertyAnnotations($property) as $annot) {
            if ($annot instanceof $annotationName) {
                return $annot;
            }
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodAnnotations(\ReflectionMethod $method)
    {
        $class = $method->getDeclaringClass();
        $cacheKey = $class->getName().'#'.$method->getName();

        if (isset($this->loadedAnnotations[$cacheKey])) {
            return $this->loadedAnnotations[$cacheKey];
        }

        if (false === ($annots = $this->fetchFromCache($cacheKey, $class))) {
            $annots = $this->delegate->getMethodAnnotations($method);
            $this->saveToCache($cacheKey, $annots);
        }

        return $this->loadedAnnotations[$cacheKey] = $annots;
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodAnnotation(\ReflectionMethod $method, $annotationName)
    {
        foreach ($this->getMethodAnnotations($method) as $annot) {
            if ($annot instanceof $annotationName) {
                return $annot;
            }
        }

        return null;
    }

    /**
     * Clears loaded annotations.
     *
     * @return void
     */
    public function clearLoadedAnnotations()
    {
        $this->loadedAnnotations = [];
<<<<<<< HEAD
=======
        $this->loadedFilemtimes = [];
>>>>>>> ThomasN
    }

    /**
     * Fetches a value from the cache.
     *
<<<<<<< HEAD
     * @param string          $cacheKey The cache key.
     * @param ReflectionClass $class    The related class.
=======
     * @param string $cacheKey The cache key.
>>>>>>> ThomasN
     *
     * @return mixed The cached value or false when the value is not in cache.
     */
    private function fetchFromCache($cacheKey, ReflectionClass $class)
    {
        if (($data = $this->cache->fetch($cacheKey)) !== false) {
            if (!$this->debug || $this->isCacheFresh($cacheKey, $class)) {
                return $data;
            }
        }

        return false;
    }

    /**
     * Saves a value to the cache.
     *
     * @param string $cacheKey The cache key.
     * @param mixed  $value    The value.
     *
     * @return void
     */
    private function saveToCache($cacheKey, $value)
    {
        $this->cache->save($cacheKey, $value);
        if ($this->debug) {
            $this->cache->save('[C]'.$cacheKey, time());
        }
    }

    /**
     * Checks if the cache is fresh.
     *
<<<<<<< HEAD
     * @param string           $cacheKey
     * @param ReflectionClass $class
=======
     * @param string $cacheKey
>>>>>>> ThomasN
     *
     * @return boolean
     */
    private function isCacheFresh($cacheKey, ReflectionClass $class)
    {
<<<<<<< HEAD
        if (null === $lastModification = $this->getLastModification($class)) {
=======
        $lastModification = $this->getLastModification($class);
        if ($lastModification === 0) {
>>>>>>> ThomasN
            return true;
        }

        return $this->cache->fetch('[C]'.$cacheKey) >= $lastModification;
    }

    /**
     * Returns the time the class was last modified, testing traits and parents
     *
<<<<<<< HEAD
     * @param ReflectionClass $class
=======
>>>>>>> ThomasN
     * @return int
     */
    private function getLastModification(ReflectionClass $class)
    {
        $filename = $class->getFileName();
<<<<<<< HEAD
        $parent   = $class->getParentClass();

        return max(array_merge(
=======

        if (isset($this->loadedFilemtimes[$filename])) {
            return $this->loadedFilemtimes[$filename];
        }

        $parent   = $class->getParentClass();

        $lastModification =  max(array_merge(
>>>>>>> ThomasN
            [$filename ? filemtime($filename) : 0],
            array_map([$this, 'getTraitLastModificationTime'], $class->getTraits()),
            array_map([$this, 'getLastModification'], $class->getInterfaces()),
            $parent ? [$this->getLastModification($parent)] : []
        ));
<<<<<<< HEAD
    }

    /**
     * @param ReflectionClass $reflectionTrait
=======

        assert($lastModification !== false);

        return $this->loadedFilemtimes[$filename] = $lastModification;
    }

    /**
>>>>>>> ThomasN
     * @return int
     */
    private function getTraitLastModificationTime(ReflectionClass $reflectionTrait)
    {
        $fileName = $reflectionTrait->getFileName();

<<<<<<< HEAD
        return max(array_merge(
            [$fileName ? filemtime($fileName) : 0],
            array_map([$this, 'getTraitLastModificationTime'], $reflectionTrait->getTraits())
        ));
=======
        if (isset($this->loadedFilemtimes[$fileName])) {
            return $this->loadedFilemtimes[$fileName];
        }

        $lastModificationTime = max(array_merge(
            [$fileName ? filemtime($fileName) : 0],
            array_map([$this, 'getTraitLastModificationTime'], $reflectionTrait->getTraits())
        ));

        assert($lastModificationTime !== false);

        return $this->loadedFilemtimes[$fileName] = $lastModificationTime;
>>>>>>> ThomasN
    }
}
