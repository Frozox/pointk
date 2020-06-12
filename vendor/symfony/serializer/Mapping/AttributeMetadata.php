<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Serializer\Mapping;

/**
 * {@inheritdoc}
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class AttributeMetadata implements AttributeMetadataInterface
{
    /**
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link getName()} instead.
     */
    public $name;

    /**
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link getGroups()} instead.
     */
    public $groups = [];

    /**
     * @var int|null
     *
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link getMaxDepth()} instead.
     */
    public $maxDepth;

    /**
     * @var string|null
     *
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link getSerializedName()} instead.
     */
    public $serializedName;

<<<<<<< HEAD
=======
    /**
     * @var bool
     *
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link isIgnored()} instead.
     */
    public $ignore = false;

>>>>>>> ThomasN
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function addGroup(string $group)
    {
        if (!\in_array($group, $this->groups)) {
            $this->groups[] = $group;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * {@inheritdoc}
     */
    public function setMaxDepth(?int $maxDepth)
    {
        $this->maxDepth = $maxDepth;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxDepth()
    {
        return $this->maxDepth;
    }

    /**
     * {@inheritdoc}
     */
    public function setSerializedName(string $serializedName = null)
    {
        $this->serializedName = $serializedName;
    }

    /**
     * {@inheritdoc}
     */
    public function getSerializedName(): ?string
    {
        return $this->serializedName;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
=======
    public function setIgnore(bool $ignore)
    {
        $this->ignore = $ignore;
    }

    /**
     * {@inheritdoc}
     */
    public function isIgnored(): bool
    {
        return $this->ignore;
    }

    /**
     * {@inheritdoc}
     */
>>>>>>> ThomasN
    public function merge(AttributeMetadataInterface $attributeMetadata)
    {
        foreach ($attributeMetadata->getGroups() as $group) {
            $this->addGroup($group);
        }

        // Overwrite only if not defined
        if (null === $this->maxDepth) {
            $this->maxDepth = $attributeMetadata->getMaxDepth();
        }

        // Overwrite only if not defined
        if (null === $this->serializedName) {
            $this->serializedName = $attributeMetadata->getSerializedName();
        }
<<<<<<< HEAD
=======

        if ($ignore = $attributeMetadata->isIgnored()) {
            $this->ignore = $ignore;
        }
>>>>>>> ThomasN
    }

    /**
     * Returns the names of the properties that should be serialized.
     *
     * @return string[]
     */
    public function __sleep()
    {
<<<<<<< HEAD
        return ['name', 'groups', 'maxDepth', 'serializedName'];
=======
        return ['name', 'groups', 'maxDepth', 'serializedName', 'ignore'];
>>>>>>> ThomasN
    }
}
