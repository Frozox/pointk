<?php
<<<<<<< HEAD
=======

declare(strict_types=1);

>>>>>>> ThomasN
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
<<<<<<< HEAD
 * @copyright 2010-2015 Mike van Riel<mike@phpdoc.org>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
=======
>>>>>>> ThomasN
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection;

use phpDocumentor\Reflection\DocBlock\Tag;
use Webmozart\Assert\Assert;

final class DocBlock
{
    /** @var string The opening line for this docblock. */
<<<<<<< HEAD
    private $summary = '';

    /** @var DocBlock\Description The actual description for this docblock. */
    private $description = null;
=======
    private $summary;

    /** @var DocBlock\Description The actual description for this docblock. */
    private $description;
>>>>>>> ThomasN

    /** @var Tag[] An array containing all the tags in this docblock; except inline. */
    private $tags = [];

<<<<<<< HEAD
    /** @var Types\Context Information about the context of this DocBlock. */
    private $context = null;

    /** @var Location Information about the location of this DocBlock. */
    private $location = null;

    /** @var bool Is this DocBlock (the start of) a template? */
    private $isTemplateStart = false;

    /** @var bool Does this DocBlock signify the end of a DocBlock template? */
    private $isTemplateEnd = false;

    /**
     * @param string $summary
     * @param DocBlock\Description $description
     * @param DocBlock\Tag[] $tags
     * @param Types\Context $context The context in which the DocBlock occurs.
     * @param Location $location The location within the file that this DocBlock occurs in.
     * @param bool $isTemplateStart
     * @param bool $isTemplateEnd
     */
    public function __construct(
        $summary = '',
        DocBlock\Description $description = null,
        array $tags = [],
        Types\Context $context = null,
        Location $location = null,
        $isTemplateStart = false,
        $isTemplateEnd = false
    ) {
        Assert::string($summary);
        Assert::boolean($isTemplateStart);
        Assert::boolean($isTemplateEnd);
        Assert::allIsInstanceOf($tags, Tag::class);

        $this->summary = $summary;
=======
    /** @var Types\Context|null Information about the context of this DocBlock. */
    private $context;

    /** @var Location|null Information about the location of this DocBlock. */
    private $location;

    /** @var bool Is this DocBlock (the start of) a template? */
    private $isTemplateStart;

    /** @var bool Does this DocBlock signify the end of a DocBlock template? */
    private $isTemplateEnd;

    /**
     * @param DocBlock\Tag[] $tags
     * @param Types\Context  $context  The context in which the DocBlock occurs.
     * @param Location       $location The location within the file that this DocBlock occurs in.
     */
    public function __construct(
        string $summary = '',
        ?DocBlock\Description $description = null,
        array $tags = [],
        ?Types\Context $context = null,
        ?Location $location = null,
        bool $isTemplateStart = false,
        bool $isTemplateEnd = false
    ) {
        Assert::allIsInstanceOf($tags, Tag::class);

        $this->summary     = $summary;
>>>>>>> ThomasN
        $this->description = $description ?: new DocBlock\Description('');
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

<<<<<<< HEAD
        $this->context = $context;
        $this->location = $location;

        $this->isTemplateEnd = $isTemplateEnd;
        $this->isTemplateStart = $isTemplateStart;
    }

    /**
     * @return string
     */
    public function getSummary()
=======
        $this->context  = $context;
        $this->location = $location;

        $this->isTemplateEnd   = $isTemplateEnd;
        $this->isTemplateStart = $isTemplateStart;
    }

    public function getSummary() : string
>>>>>>> ThomasN
    {
        return $this->summary;
    }

<<<<<<< HEAD
    /**
     * @return DocBlock\Description
     */
    public function getDescription()
=======
    public function getDescription() : DocBlock\Description
>>>>>>> ThomasN
    {
        return $this->description;
    }

    /**
     * Returns the current context.
<<<<<<< HEAD
     *
     * @return Types\Context
     */
    public function getContext()
=======
     */
    public function getContext() : ?Types\Context
>>>>>>> ThomasN
    {
        return $this->context;
    }

    /**
     * Returns the current location.
<<<<<<< HEAD
     *
     * @return Location
     */
    public function getLocation()
=======
     */
    public function getLocation() : ?Location
>>>>>>> ThomasN
    {
        return $this->location;
    }

    /**
     * Returns whether this DocBlock is the start of a Template section.
     *
     * A Docblock may serve as template for a series of subsequent DocBlocks. This is indicated by a special marker
     * (`#@+`) that is appended directly after the opening `/**` of a DocBlock.
     *
     * An example of such an opening is:
     *
     * ```
     * /**#@+
     *  * My DocBlock
     *  * /
     * ```
     *
     * The description and tags (not the summary!) are copied onto all subsequent DocBlocks and also applied to all
     * elements that follow until another DocBlock is found that contains the closing marker (`#@-`).
     *
     * @see self::isTemplateEnd() for the check whether a closing marker was provided.
<<<<<<< HEAD
     *
     * @return boolean
     */
    public function isTemplateStart()
=======
     */
    public function isTemplateStart() : bool
>>>>>>> ThomasN
    {
        return $this->isTemplateStart;
    }

    /**
     * Returns whether this DocBlock is the end of a Template section.
     *
     * @see self::isTemplateStart() for a more complete description of the Docblock Template functionality.
<<<<<<< HEAD
     *
     * @return boolean
     */
    public function isTemplateEnd()
=======
     */
    public function isTemplateEnd() : bool
>>>>>>> ThomasN
    {
        return $this->isTemplateEnd;
    }

    /**
     * Returns the tags for this DocBlock.
     *
     * @return Tag[]
     */
<<<<<<< HEAD
    public function getTags()
=======
    public function getTags() : array
>>>>>>> ThomasN
    {
        return $this->tags;
    }

    /**
     * Returns an array of tags matching the given name. If no tags are found
     * an empty array is returned.
     *
     * @param string $name String to search by.
     *
     * @return Tag[]
     */
<<<<<<< HEAD
    public function getTagsByName($name)
    {
        Assert::string($name);

        $result = [];

        /** @var Tag $tag */
=======
    public function getTagsByName(string $name) : array
    {
        $result = [];

>>>>>>> ThomasN
        foreach ($this->getTags() as $tag) {
            if ($tag->getName() !== $name) {
                continue;
            }

            $result[] = $tag;
        }

        return $result;
    }

    /**
     * Checks if a tag of a certain type is present in this DocBlock.
     *
     * @param string $name Tag name to check for.
<<<<<<< HEAD
     *
     * @return bool
     */
    public function hasTag($name)
    {
        Assert::string($name);

        /** @var Tag $tag */
=======
     */
    public function hasTag(string $name) : bool
    {
>>>>>>> ThomasN
        foreach ($this->getTags() as $tag) {
            if ($tag->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Remove a tag from this DocBlock.
     *
<<<<<<< HEAD
     * @param Tag $tag The tag to remove.
     *
     * @return void
     */
    public function removeTag(Tag $tagToRemove)
=======
     * @param Tag $tagToRemove The tag to remove.
     */
    public function removeTag(Tag $tagToRemove) : void
>>>>>>> ThomasN
    {
        foreach ($this->tags as $key => $tag) {
            if ($tag === $tagToRemove) {
                unset($this->tags[$key]);
                break;
            }
        }
    }

    /**
     * Adds a tag to this DocBlock.
     *
     * @param Tag $tag The tag to add.
<<<<<<< HEAD
     *
     * @return void
     */
    private function addTag(Tag $tag)
=======
     */
    private function addTag(Tag $tag) : void
>>>>>>> ThomasN
    {
        $this->tags[] = $tag;
    }
}
