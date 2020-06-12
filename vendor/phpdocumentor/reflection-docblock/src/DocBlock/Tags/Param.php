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
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;
use Webmozart\Assert\Assert;
<<<<<<< HEAD
=======
use function array_shift;
use function array_unshift;
use function implode;
use function preg_split;
use function strpos;
use function substr;
use const PREG_SPLIT_DELIM_CAPTURE;
>>>>>>> ThomasN

/**
 * Reflection class for the {@}param tag in a Docblock.
 */
final class Param extends TagWithType implements Factory\StaticMethod
{
<<<<<<< HEAD
    /** @var string */
    private $variableName = '';

    /** @var bool determines whether this is a variadic argument */
    private $isVariadic = false;

    /**
     * @param string $variableName
     * @param Type $type
     * @param bool $isVariadic
     * @param Description $description
     */
    public function __construct($variableName, Type $type = null, $isVariadic = false, Description $description = null)
    {
        Assert::string($variableName);
        Assert::boolean($isVariadic);

        $this->name = 'param';
        $this->variableName = $variableName;
        $this->type = $type;
        $this->isVariadic = $isVariadic;
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(
        $body,
        TypeResolver $typeResolver = null,
        DescriptionFactory $descriptionFactory = null,
        TypeContext $context = null
    ) {
        Assert::stringNotEmpty($body);
        Assert::allNotNull([$typeResolver, $descriptionFactory]);

        list($firstPart, $body) = self::extractTypeFromBody($body);
        $type = null;
        $parts = preg_split('/(\s+)/Su', $body, 2, PREG_SPLIT_DELIM_CAPTURE);
        $variableName = '';
        $isVariadic = false;

        // if the first item that is encountered is not a variable; it is a type
        if ($firstPart && (strlen($firstPart) > 0) && ($firstPart[0] !== '$')) {
=======
    /** @var string|null */
    private $variableName;

    /** @var bool determines whether this is a variadic argument */
    private $isVariadic;

    public function __construct(
        ?string $variableName,
        ?Type $type = null,
        bool $isVariadic = false,
        ?Description $description = null
    ) {
        $this->name         = 'param';
        $this->variableName = $variableName;
        $this->type         = $type;
        $this->isVariadic   = $isVariadic;
        $this->description  = $description;
    }

    public static function create(
        string $body,
        ?TypeResolver $typeResolver = null,
        ?DescriptionFactory $descriptionFactory = null,
        ?TypeContext $context = null
    ) : self {
        Assert::stringNotEmpty($body);
        Assert::notNull($typeResolver);
        Assert::notNull($descriptionFactory);

        [$firstPart, $body] = self::extractTypeFromBody($body);

        $type         = null;
        $parts        = preg_split('/(\s+)/Su', $body, 2, PREG_SPLIT_DELIM_CAPTURE);
        Assert::isArray($parts);
        $variableName = '';
        $isVariadic   = false;

        // if the first item that is encountered is not a variable; it is a type
        if ($firstPart && $firstPart[0] !== '$') {
>>>>>>> ThomasN
            $type = $typeResolver->resolve($firstPart, $context);
        } else {
            // first part is not a type; we should prepend it to the parts array for further processing
            array_unshift($parts, $firstPart);
        }

        // if the next item starts with a $ or ...$ it must be the variable name
<<<<<<< HEAD
        if (isset($parts[0])
            && (strlen($parts[0]) > 0)
            && ($parts[0][0] === '$' || substr($parts[0], 0, 4) === '...$')
        ) {
            $variableName = array_shift($parts);
            array_shift($parts);

            if (substr($variableName, 0, 3) === '...') {
                $isVariadic = true;
                $variableName = substr($variableName, 3);
            }

            if (substr($variableName, 0, 1) === '$') {
=======
        if (isset($parts[0]) && (strpos($parts[0], '$') === 0 || strpos($parts[0], '...$') === 0)) {
            $variableName = array_shift($parts);
            array_shift($parts);

            Assert::notNull($variableName);

            if (strpos($variableName, '...') === 0) {
                $isVariadic   = true;
                $variableName = substr($variableName, 3);
            }

            if (strpos($variableName, '$') === 0) {
>>>>>>> ThomasN
                $variableName = substr($variableName, 1);
            }
        }

        $description = $descriptionFactory->create(implode('', $parts), $context);

        return new static($variableName, $type, $isVariadic, $description);
    }

    /**
     * Returns the variable's name.
<<<<<<< HEAD
     *
     * @return string
     */
    public function getVariableName()
=======
     */
    public function getVariableName() : ?string
>>>>>>> ThomasN
    {
        return $this->variableName;
    }

    /**
     * Returns whether this tag is variadic.
<<<<<<< HEAD
     *
     * @return boolean
     */
    public function isVariadic()
=======
     */
    public function isVariadic() : bool
>>>>>>> ThomasN
    {
        return $this->isVariadic;
    }

    /**
     * Returns a string representation for this tag.
<<<<<<< HEAD
     *
     * @return string
     */
    public function __toString()
    {
        return ($this->type ? $this->type . ' ' : '')
            . ($this->isVariadic() ? '...' : '')
            . '$' . $this->variableName
=======
     */
    public function __toString() : string
    {
        return ($this->type ? $this->type . ' ' : '')
            . ($this->isVariadic() ? '...' : '')
            . ($this->variableName !== null ? '$' . $this->variableName : '')
>>>>>>> ThomasN
            . ($this->description ? ' ' . $this->description : '');
    }
}
