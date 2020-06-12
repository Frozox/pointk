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
 * @link      http://phpdoc.org
=======
 * @link http://phpdoc.org
>>>>>>> ThomasN
 */

namespace phpDocumentor\Reflection\DocBlock;

use phpDocumentor\Reflection\DocBlock;
<<<<<<< HEAD
use Webmozart\Assert\Assert;
=======
use phpDocumentor\Reflection\DocBlock\Tags\Formatter;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter\PassthroughFormatter;
use function sprintf;
use function str_repeat;
use function str_replace;
use function strlen;
use function wordwrap;
>>>>>>> ThomasN

/**
 * Converts a DocBlock back from an object to a complete DocComment including Asterisks.
 */
class Serializer
{
    /** @var string The string to indent the comment with. */
    protected $indentString = ' ';

    /** @var int The number of times the indent string is repeated. */
    protected $indent = 0;

    /** @var bool Whether to indent the first line with the given indent amount and string. */
    protected $isFirstLineIndented = true;

    /** @var int|null The max length of a line. */
<<<<<<< HEAD
    protected $lineLength = null;

    /** @var DocBlock\Tags\Formatter A custom tag formatter. */
    protected $tagFormatter = null;
=======
    protected $lineLength;

    /** @var Formatter A custom tag formatter. */
    protected $tagFormatter;
>>>>>>> ThomasN

    /**
     * Create a Serializer instance.
     *
<<<<<<< HEAD
     * @param int $indent The number of times the indent string is repeated.
     * @param string   $indentString    The string to indent the comment with.
     * @param bool     $indentFirstLine Whether to indent the first line.
     * @param int|null $lineLength The max length of a line or NULL to disable line wrapping.
     * @param DocBlock\Tags\Formatter $tagFormatter A custom tag formatter, defaults to PassthroughFormatter.
     */
    public function __construct($indent = 0, $indentString = ' ', $indentFirstLine = true, $lineLength = null, $tagFormatter = null)
    {
        Assert::integer($indent);
        Assert::string($indentString);
        Assert::boolean($indentFirstLine);
        Assert::nullOrInteger($lineLength);
        Assert::nullOrIsInstanceOf($tagFormatter, 'phpDocumentor\Reflection\DocBlock\Tags\Formatter');

        $this->indent = $indent;
        $this->indentString = $indentString;
        $this->isFirstLineIndented = $indentFirstLine;
        $this->lineLength = $lineLength;
        $this->tagFormatter = $tagFormatter ?: new DocBlock\Tags\Formatter\PassthroughFormatter();
=======
     * @param int       $indent          The number of times the indent string is repeated.
     * @param string    $indentString    The string to indent the comment with.
     * @param bool      $indentFirstLine Whether to indent the first line.
     * @param int|null  $lineLength      The max length of a line or NULL to disable line wrapping.
     * @param Formatter $tagFormatter    A custom tag formatter, defaults to PassthroughFormatter.
     */
    public function __construct(
        int $indent = 0,
        string $indentString = ' ',
        bool $indentFirstLine = true,
        ?int $lineLength = null,
        ?Formatter $tagFormatter = null
    ) {
        $this->indent              = $indent;
        $this->indentString        = $indentString;
        $this->isFirstLineIndented = $indentFirstLine;
        $this->lineLength          = $lineLength;
        $this->tagFormatter        = $tagFormatter ?: new PassthroughFormatter();
>>>>>>> ThomasN
    }

    /**
     * Generate a DocBlock comment.
     *
     * @param DocBlock $docblock The DocBlock to serialize.
     *
     * @return string The serialized doc block.
     */
<<<<<<< HEAD
    public function getDocComment(DocBlock $docblock)
    {
        $indent = str_repeat($this->indentString, $this->indent);
=======
    public function getDocComment(DocBlock $docblock) : string
    {
        $indent      = str_repeat($this->indentString, $this->indent);
>>>>>>> ThomasN
        $firstIndent = $this->isFirstLineIndented ? $indent : '';
        // 3 === strlen(' * ')
        $wrapLength = $this->lineLength ? $this->lineLength - strlen($indent) - 3 : null;

        $text = $this->removeTrailingSpaces(
            $indent,
            $this->addAsterisksForEachLine(
                $indent,
                $this->getSummaryAndDescriptionTextBlock($docblock, $wrapLength)
            )
        );

<<<<<<< HEAD
        $comment = "{$firstIndent}/**\n";
        if ($text) {
            $comment .= "{$indent} * {$text}\n";
            $comment .= "{$indent} *\n";
        }

        $comment = $this->addTagBlock($docblock, $wrapLength, $indent, $comment);
        $comment .= $indent . ' */';

        return $comment;
    }

    /**
     * @param $indent
     * @param $text
     * @return mixed
     */
    private function removeTrailingSpaces($indent, $text)
    {
        return str_replace("\n{$indent} * \n", "\n{$indent} *\n", $text);
    }

    /**
     * @param $indent
     * @param $text
     * @return mixed
     */
    private function addAsterisksForEachLine($indent, $text)
    {
        return str_replace("\n", "\n{$indent} * ", $text);
    }

    /**
     * @param DocBlock $docblock
     * @param $wrapLength
     * @return string
     */
    private function getSummaryAndDescriptionTextBlock(DocBlock $docblock, $wrapLength)
    {
        $text = $docblock->getSummary() . ((string)$docblock->getDescription() ? "\n\n" . $docblock->getDescription()
                : '');
        if ($wrapLength !== null) {
            $text = wordwrap($text, $wrapLength);
=======
        $comment = $firstIndent . "/**\n";
        if ($text) {
            $comment .= $indent . ' * ' . $text . "\n";
            $comment .= $indent . " *\n";
        }

        $comment = $this->addTagBlock($docblock, $wrapLength, $indent, $comment);

        return $comment . $indent . ' */';
    }

    private function removeTrailingSpaces(string $indent, string $text) : string
    {
        return str_replace(
            sprintf("\n%s * \n", $indent),
            sprintf("\n%s *\n", $indent),
            $text
        );
    }

    private function addAsterisksForEachLine(string $indent, string $text) : string
    {
        return str_replace(
            "\n",
            sprintf("\n%s * ", $indent),
            $text
        );
    }

    private function getSummaryAndDescriptionTextBlock(DocBlock $docblock, ?int $wrapLength) : string
    {
        $text = $docblock->getSummary() . ((string) $docblock->getDescription() ? "\n\n" . $docblock->getDescription()
                : '');
        if ($wrapLength !== null) {
            $text = wordwrap($text, $wrapLength);

>>>>>>> ThomasN
            return $text;
        }

        return $text;
    }

<<<<<<< HEAD
    /**
     * @param DocBlock $docblock
     * @param $wrapLength
     * @param $indent
     * @param $comment
     * @return string
     */
    private function addTagBlock(DocBlock $docblock, $wrapLength, $indent, $comment)
=======
    private function addTagBlock(DocBlock $docblock, ?int $wrapLength, string $indent, string $comment) : string
>>>>>>> ThomasN
    {
        foreach ($docblock->getTags() as $tag) {
            $tagText = $this->tagFormatter->format($tag);
            if ($wrapLength !== null) {
                $tagText = wordwrap($tagText, $wrapLength);
            }

<<<<<<< HEAD
            $tagText = str_replace("\n", "\n{$indent} * ", $tagText);

            $comment .= "{$indent} * {$tagText}\n";
=======
            $tagText = str_replace(
                "\n",
                sprintf("\n%s * ", $indent),
                $tagText
            );

            $comment .= sprintf("%s * %s\n", $indent, $tagText);
>>>>>>> ThomasN
        }

        return $comment;
    }
}
