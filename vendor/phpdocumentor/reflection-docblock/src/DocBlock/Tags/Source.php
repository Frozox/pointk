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

namespace phpDocumentor\Reflection\DocBlock\Tags;

use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\Types\Context as TypeContext;
use Webmozart\Assert\Assert;
<<<<<<< HEAD
=======
use function preg_match;
>>>>>>> ThomasN

/**
 * Reflection class for a {@}source tag in a Docblock.
 */
final class Source extends BaseTag implements Factory\StaticMethod
{
    /** @var string */
    protected $name = 'source';

    /** @var int The starting line, relative to the structural element's location. */
<<<<<<< HEAD
    private $startingLine = 1;

    /** @var int|null The number of lines, relative to the starting line. NULL means "to the end". */
    private $lineCount = null;

    public function __construct($startingLine, $lineCount = null, Description $description = null)
=======
    private $startingLine;

    /** @var int|null The number of lines, relative to the starting line. NULL means "to the end". */
    private $lineCount;

    /**
     * @param int|string      $startingLine should be a to int convertible value
     * @param int|string|null $lineCount    should be a to int convertible value
     */
    public function __construct($startingLine, $lineCount = null, ?Description $description = null)
>>>>>>> ThomasN
    {
        Assert::integerish($startingLine);
        Assert::nullOrIntegerish($lineCount);

<<<<<<< HEAD
        $this->startingLine = (int)$startingLine;
        $this->lineCount    = $lineCount !== null ? (int)$lineCount : null;
        $this->description  = $description;
    }

    /**
     * {@inheritdoc}
     */
    public static function create($body, DescriptionFactory $descriptionFactory = null, TypeContext $context = null)
    {
=======
        $this->startingLine = (int) $startingLine;
        $this->lineCount    = $lineCount !== null ? (int) $lineCount : null;
        $this->description  = $description;
    }

    public static function create(
        string $body,
        ?DescriptionFactory $descriptionFactory = null,
        ?TypeContext $context = null
    ) : self {
>>>>>>> ThomasN
        Assert::stringNotEmpty($body);
        Assert::notNull($descriptionFactory);

        $startingLine = 1;
        $lineCount    = null;
        $description  = null;

        // Starting line / Number of lines / Description
        if (preg_match('/^([1-9]\d*)\s*(?:((?1))\s+)?(.*)$/sux', $body, $matches)) {
<<<<<<< HEAD
            $startingLine = (int)$matches[1];
            if (isset($matches[2]) && $matches[2] !== '') {
                $lineCount = (int)$matches[2];
=======
            $startingLine = (int) $matches[1];
            if (isset($matches[2]) && $matches[2] !== '') {
                $lineCount = (int) $matches[2];
>>>>>>> ThomasN
            }

            $description = $matches[3];
        }

<<<<<<< HEAD
        return new static($startingLine, $lineCount, $descriptionFactory->create($description, $context));
=======
        return new static($startingLine, $lineCount, $descriptionFactory->create($description??'', $context));
>>>>>>> ThomasN
    }

    /**
     * Gets the starting line.
     *
     * @return int The starting line, relative to the structural element's
     *     location.
     */
<<<<<<< HEAD
    public function getStartingLine()
=======
    public function getStartingLine() : int
>>>>>>> ThomasN
    {
        return $this->startingLine;
    }

    /**
     * Returns the number of lines.
     *
     * @return int|null The number of lines, relative to the starting line. NULL
     *     means "to the end".
     */
<<<<<<< HEAD
    public function getLineCount()
=======
    public function getLineCount() : ?int
>>>>>>> ThomasN
    {
        return $this->lineCount;
    }

<<<<<<< HEAD
    public function __toString()
    {
        return $this->startingLine
        . ($this->lineCount !== null ? ' ' . $this->lineCount : '')
        . ($this->description ? ' ' . $this->description->render() : '');
=======
    public function __toString() : string
    {
        return $this->startingLine
            . ($this->lineCount !== null ? ' ' . $this->lineCount : '')
            . ($this->description ? ' ' . (string) $this->description : '');
>>>>>>> ThomasN
    }
}
