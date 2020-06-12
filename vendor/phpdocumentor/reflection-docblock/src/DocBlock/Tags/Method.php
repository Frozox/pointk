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

namespace phpDocumentor\Reflection\DocBlock\Tags;

<<<<<<< HEAD
=======
use InvalidArgumentException;
>>>>>>> ThomasN
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;
<<<<<<< HEAD
use phpDocumentor\Reflection\Types\Void_;
use Webmozart\Assert\Assert;
=======
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\Void_;
use Webmozart\Assert\Assert;
use function array_keys;
use function explode;
use function implode;
use function is_string;
use function preg_match;
use function sort;
use function strpos;
use function substr;
use function trim;
use function var_export;
>>>>>>> ThomasN

/**
 * Reflection class for an {@}method in a Docblock.
 */
final class Method extends BaseTag implements Factory\StaticMethod
{
<<<<<<< HEAD
    protected $name = 'method';

    /** @var string */
    private $methodName = '';

    /** @var string[] */
    private $arguments = [];

    /** @var bool */
    private $isStatic = false;
=======
    /** @var string */
    protected $name = 'method';

    /** @var string */
    private $methodName;

    /**
     * @phpstan-var array<int, array{name: string, type: Type}>
     * @var array<int, array<string, Type|string>>
     */
    private $arguments;

    /** @var bool */
    private $isStatic;
>>>>>>> ThomasN

    /** @var Type */
    private $returnType;

<<<<<<< HEAD
    public function __construct(
        $methodName,
        array $arguments = [],
        Type $returnType = null,
        $static = false,
        Description $description = null
    ) {
        Assert::stringNotEmpty($methodName);
        Assert::boolean($static);
=======
    /**
     * @param array<int, array<string, Type|string>> $arguments
     *
     * @phpstan-param array<int, array{name: string, type: Type}|string> $arguments
     */
    public function __construct(
        string $methodName,
        array $arguments = [],
        ?Type $returnType = null,
        bool $static = false,
        ?Description $description = null
    ) {
        Assert::stringNotEmpty($methodName);
>>>>>>> ThomasN

        if ($returnType === null) {
            $returnType = new Void_();
        }

        $this->methodName  = $methodName;
        $this->arguments   = $this->filterArguments($arguments);
        $this->returnType  = $returnType;
        $this->isStatic    = $static;
        $this->description = $description;
    }

<<<<<<< HEAD
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
        Assert::allNotNull([ $typeResolver, $descriptionFactory ]);
=======
    public static function create(
        string $body,
        ?TypeResolver $typeResolver = null,
        ?DescriptionFactory $descriptionFactory = null,
        ?TypeContext $context = null
    ) : ?self {
        Assert::stringNotEmpty($body);
        Assert::notNull($typeResolver);
        Assert::notNull($descriptionFactory);
>>>>>>> ThomasN

        // 1. none or more whitespace
        // 2. optionally the keyword "static" followed by whitespace
        // 3. optionally a word with underscores followed by whitespace : as
        //    type for the return value
        // 4. then optionally a word with underscores followed by () and
        //    whitespace : as method name as used by phpDocumentor
        // 5. then a word with underscores, followed by ( and any character
        //    until a ) and whitespace : as method name with signature
        // 6. any remaining text : as description
        if (!preg_match(
            '/^
                # Static keyword
                # Declares a static method ONLY if type is also present
                (?:
                    (static)
                    \s+
                )?
                # Return type
                (?:
<<<<<<< HEAD
                    (   
=======
                    (
>>>>>>> ThomasN
                        (?:[\w\|_\\\\]*\$this[\w\|_\\\\]*)
                        |
                        (?:
                            (?:[\w\|_\\\\]+)
<<<<<<< HEAD
                            # array notation           
                            (?:\[\])*
                        )*
=======
                            # array notation
                            (?:\[\])*
                        )*+
>>>>>>> ThomasN
                    )
                    \s+
                )?
                # Method name
                ([\w_]+)
                # Arguments
                (?:
                    \(([^\)]*)\)
                )?
                \s*
                # Description
                (.*)
            $/sux',
            $body,
            $matches
        )) {
            return null;
        }

<<<<<<< HEAD
        list(, $static, $returnType, $methodName, $arguments, $description) = $matches;

        $static      = $static === 'static';
=======
        [, $static, $returnType, $methodName, $argumentLines, $description] = $matches;

        $static = $static === 'static';
>>>>>>> ThomasN

        if ($returnType === '') {
            $returnType = 'void';
        }

        $returnType  = $typeResolver->resolve($returnType, $context);
        $description = $descriptionFactory->create($description, $context);

<<<<<<< HEAD
        if (is_string($arguments) && strlen($arguments) > 0) {
            $arguments = explode(',', $arguments);
            foreach ($arguments as &$argument) {
                $argument = explode(' ', self::stripRestArg(trim($argument)), 2);
                if ($argument[0][0] === '$') {
                    $argumentName = substr($argument[0], 1);
                    $argumentType = new Void_();
=======
        /** @phpstan-var array<int, array{name: string, type: Type}> $arguments */
        $arguments = [];
        if ($argumentLines !== '') {
            $argumentsExploded = explode(',', $argumentLines);
            foreach ($argumentsExploded as $argument) {
                $argument = explode(' ', self::stripRestArg(trim($argument)), 2);
                if (strpos($argument[0], '$') === 0) {
                    $argumentName = substr($argument[0], 1);
                    $argumentType = new Mixed_();
>>>>>>> ThomasN
                } else {
                    $argumentType = $typeResolver->resolve($argument[0], $context);
                    $argumentName = '';
                    if (isset($argument[1])) {
<<<<<<< HEAD
                        $argument[1] = self::stripRestArg($argument[1]);
=======
                        $argument[1]  = self::stripRestArg($argument[1]);
>>>>>>> ThomasN
                        $argumentName = substr($argument[1], 1);
                    }
                }

<<<<<<< HEAD
                $argument = [ 'name' => $argumentName, 'type' => $argumentType];
            }
        } else {
            $arguments = [];
=======
                $arguments[] = ['name' => $argumentName, 'type' => $argumentType];
            }
>>>>>>> ThomasN
        }

        return new static($methodName, $arguments, $returnType, $static, $description);
    }

    /**
     * Retrieves the method name.
<<<<<<< HEAD
     *
     * @return string
     */
    public function getMethodName()
=======
     */
    public function getMethodName() : string
>>>>>>> ThomasN
    {
        return $this->methodName;
    }

    /**
<<<<<<< HEAD
     * @return string[]
     */
    public function getArguments()
=======
     * @return array<int, array<string, Type|string>>
     *
     * @phpstan-return array<int, array{name: string, type: Type}>
     */
    public function getArguments() : array
>>>>>>> ThomasN
    {
        return $this->arguments;
    }

    /**
     * Checks whether the method tag describes a static method or not.
     *
     * @return bool TRUE if the method declaration is for a static method, FALSE otherwise.
     */
<<<<<<< HEAD
    public function isStatic()
=======
    public function isStatic() : bool
>>>>>>> ThomasN
    {
        return $this->isStatic;
    }

<<<<<<< HEAD
    /**
     * @return Type
     */
    public function getReturnType()
=======
    public function getReturnType() : Type
>>>>>>> ThomasN
    {
        return $this->returnType;
    }

<<<<<<< HEAD
    public function __toString()
=======
    public function __toString() : string
>>>>>>> ThomasN
    {
        $arguments = [];
        foreach ($this->arguments as $argument) {
            $arguments[] = $argument['type'] . ' $' . $argument['name'];
        }

        return trim(($this->isStatic() ? 'static ' : '')
<<<<<<< HEAD
            . (string)$this->returnType . ' '
=======
            . (string) $this->returnType . ' '
>>>>>>> ThomasN
            . $this->methodName
            . '(' . implode(', ', $arguments) . ')'
            . ($this->description ? ' ' . $this->description->render() : ''));
    }

<<<<<<< HEAD
    private function filterArguments($arguments)
    {
        foreach ($arguments as &$argument) {
            if (is_string($argument)) {
                $argument = [ 'name' => $argument ];
            }

            if (! isset($argument['type'])) {
                $argument['type'] = new Void_();
=======
    /**
     * @param mixed[][]|string[] $arguments
     *
     * @return mixed[][]
     *
     * @phpstan-param array<int, array{name: string, type: Type}|string> $arguments
     * @phpstan-return array<int, array{name: string, type: Type}>
     */
    private function filterArguments(array $arguments = []) : array
    {
        $result = [];
        foreach ($arguments as $argument) {
            if (is_string($argument)) {
                $argument = ['name' => $argument];
            }

            if (!isset($argument['type'])) {
                $argument['type'] = new Mixed_();
>>>>>>> ThomasN
            }

            $keys = array_keys($argument);
            sort($keys);
<<<<<<< HEAD
            if ($keys !== [ 'name', 'type' ]) {
                throw new \InvalidArgumentException(
                    'Arguments can only have the "name" and "type" fields, found: ' . var_export($keys, true)
                );
            }
        }

        return $arguments;
    }

    private static function stripRestArg($argument)
=======
            if ($keys !== ['name', 'type']) {
                throw new InvalidArgumentException(
                    'Arguments can only have the "name" and "type" fields, found: ' . var_export($keys, true)
                );
            }

            $result[] = $argument;
        }

        return $result;
    }

    private static function stripRestArg(string $argument) : string
>>>>>>> ThomasN
    {
        if (strpos($argument, '...') === 0) {
            $argument = trim(substr($argument, 3));
        }

        return $argument;
    }
}
