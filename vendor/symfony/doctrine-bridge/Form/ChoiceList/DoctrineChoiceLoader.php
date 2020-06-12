<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bridge\Doctrine\Form\ChoiceList;

use Doctrine\Persistence\ObjectManager;
<<<<<<< HEAD
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;
=======
use Symfony\Component\Form\ChoiceList\Loader\AbstractChoiceLoader;
>>>>>>> ThomasN

/**
 * Loads choices using a Doctrine object manager.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
<<<<<<< HEAD
class DoctrineChoiceLoader implements ChoiceLoaderInterface
=======
class DoctrineChoiceLoader extends AbstractChoiceLoader
>>>>>>> ThomasN
{
    private $manager;
    private $class;
    private $idReader;
    private $objectLoader;

    /**
<<<<<<< HEAD
     * @var ChoiceListInterface
     */
    private $choiceList;

    /**
=======
>>>>>>> ThomasN
     * Creates a new choice loader.
     *
     * Optionally, an implementation of {@link EntityLoaderInterface} can be
     * passed which optimizes the object loading for one of the Doctrine
     * mapper implementations.
     *
     * @param string $class The class name of the loaded objects
     */
    public function __construct(ObjectManager $manager, string $class, IdReader $idReader = null, EntityLoaderInterface $objectLoader = null)
    {
        $classMetadata = $manager->getClassMetadata($class);

        if ($idReader && !$idReader->isSingleId()) {
            throw new \InvalidArgumentException(sprintf('The second argument `$idReader` of "%s" must be null when the query cannot be optimized because of composite id fields.', __METHOD__));
        }

        $this->manager = $manager;
        $this->class = $classMetadata->getName();
        $this->idReader = $idReader;
        $this->objectLoader = $objectLoader;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function loadChoiceList(callable $value = null)
    {
        if ($this->choiceList) {
            return $this->choiceList;
        }

        $objects = $this->objectLoader
            ? $this->objectLoader->getEntities()
            : $this->manager->getRepository($this->class)->findAll();

        return $this->choiceList = new ArrayChoiceList($objects, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function loadValuesForChoices(array $choices, callable $value = null)
    {
        // Performance optimization
        if (empty($choices)) {
            return [];
        }

        // Optimize performance for single-field identifiers. We already
        // know that the IDs are used as values
        $optimize = $this->idReader && (null === $value || \is_array($value) && $value[0] === $this->idReader);

        // Attention: This optimization does not check choices for existence
        if ($optimize && !$this->choiceList) {
            $values = [];

            // Maintain order and indices of the given objects
            foreach ($choices as $i => $object) {
                if ($object instanceof $this->class) {
                    // Make sure to convert to the right format
                    $values[$i] = (string) $this->idReader->getIdValue($object);
=======
    protected function loadChoices(): iterable
    {
        return $this->objectLoader
            ? $this->objectLoader->getEntities()
            : $this->manager->getRepository($this->class)->findAll();
    }

    /**
     * @internal to be remove in Symfony 6
     */
    protected function doLoadValuesForChoices(array $choices): array
    {
        // Optimize performance for single-field identifiers. We already
        // know that the IDs are used as values
        // Attention: This optimization does not check choices for existence
        if ($this->idReader) {
            trigger_deprecation('symfony/doctrine-bridge', '5.1', 'Not defining explicitly the IdReader as value callback when query can be optimized is deprecated. Don\'t pass the IdReader to "%s" or define the "choice_value" option instead.', __CLASS__);
            // Maintain order and indices of the given objects
            $values = [];
            foreach ($choices as $i => $object) {
                if ($object instanceof $this->class) {
                    $values[$i] = $this->idReader->getIdValue($object);
>>>>>>> ThomasN
                }
            }

            return $values;
        }

<<<<<<< HEAD
        return $this->loadChoiceList($value)->getValuesForChoices($choices);
    }

    /**
     * {@inheritdoc}
     */
    public function loadChoicesForValues(array $values, callable $value = null)
    {
        // Performance optimization
        // Also prevents the generation of "WHERE id IN ()" queries through the
        // object loader. At least with MySQL and on the development machine
        // this was tested on, no exception was thrown for such invalid
        // statements, consequently no test fails when this code is removed.
        // https://github.com/symfony/symfony/pull/8981#issuecomment-24230557
        if (empty($values)) {
            return [];
=======
        return parent::doLoadValuesForChoices($choices);
    }

    protected function doLoadChoicesForValues(array $values, ?callable $value): array
    {
        $legacy = $this->idReader && null === $value;

        if ($legacy) {
            trigger_deprecation('symfony/doctrine-bridge', '5.1', 'Not defining explicitly the IdReader as value callback when query can be optimized is deprecated. Don\'t pass the IdReader to "%s" or define the "choice_value" option instead.', __CLASS__);
>>>>>>> ThomasN
        }

        // Optimize performance in case we have an object loader and
        // a single-field identifier
<<<<<<< HEAD
        $optimize = $this->idReader && (null === $value || \is_array($value) && $this->idReader === $value[0]);

        if ($optimize && !$this->choiceList && $this->objectLoader) {
            $unorderedObjects = $this->objectLoader->getEntitiesByIds($this->idReader->getIdField(), $values);
            $objectsById = [];
            $objects = [];
=======
        if (($legacy || \is_array($value) && $this->idReader === $value[0]) && $this->objectLoader) {
            $objects = [];
            $objectsById = [];
>>>>>>> ThomasN

            // Maintain order and indices from the given $values
            // An alternative approach to the following loop is to add the
            // "INDEX BY" clause to the Doctrine query in the loader,
            // but I'm not sure whether that's doable in a generic fashion.
<<<<<<< HEAD
            foreach ($unorderedObjects as $object) {
                $objectsById[(string) $this->idReader->getIdValue($object)] = $object;
=======
            foreach ($this->objectLoader->getEntitiesByIds($this->idReader->getIdField(), $values) as $object) {
                $objectsById[$this->idReader->getIdValue($object)] = $object;
>>>>>>> ThomasN
            }

            foreach ($values as $i => $id) {
                if (isset($objectsById[$id])) {
                    $objects[$i] = $objectsById[$id];
                }
            }

            return $objects;
        }

<<<<<<< HEAD
        return $this->loadChoiceList($value)->getChoicesForValues($values);
=======
        return parent::doLoadChoicesForValues($values, $value);
>>>>>>> ThomasN
    }
}
