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

<<<<<<< HEAD
use phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod;
use phpDocumentor\Reflection\DocBlock\Tags\Generic;
use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;
use Webmozart\Assert\Assert;
=======
use InvalidArgumentException;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use phpDocumentor\Reflection\DocBlock\Tags\Covers;
use phpDocumentor\Reflection\DocBlock\Tags\Deprecated;
use phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod;
use phpDocumentor\Reflection\DocBlock\Tags\Generic;
use phpDocumentor\Reflection\DocBlock\Tags\InvalidTag;
use phpDocumentor\Reflection\DocBlock\Tags\Link as LinkTag;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use phpDocumentor\Reflection\DocBlock\Tags\PropertyRead;
use phpDocumentor\Reflection\DocBlock\Tags\PropertyWrite;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use phpDocumentor\Reflection\DocBlock\Tags\See as SeeTag;
use phpDocumentor\Reflection\DocBlock\Tags\Since;
use phpDocumentor\Reflection\DocBlock\Tags\Source;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use phpDocumentor\Reflection\DocBlock\Tags\Version;
use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;
use ReflectionMethod;
use ReflectionParameter;
use Webmozart\Assert\Assert;
use function array_merge;
use function array_slice;
use function call_user_func_array;
use function count;
use function get_class;
use function preg_match;
use function strpos;
use function trim;
>>>>>>> ThomasN

/**
 * Creates a Tag object given the contents of a tag.
 *
 * This Factory is capable of determining the appropriate class for a tag and instantiate it using its `create`
 * factory method. The `create` factory method of a Tag can have a variable number of arguments; this way you can
 * pass the dependencies that you need to construct a tag object.
 *
 * > Important: each parameter in addition to the body variable for the `create` method must default to null, otherwise
 * > it violates the constraint with the interface; it is recommended to use the {@see Assert::notNull()} method to
 * > verify that a dependency is actually passed.
 *
 * This Factory also features a Service Locator component that is used to pass the right dependencies to the
 * `create` method of a tag; each dependency should be registered as a service or as a parameter.
 *
 * When you want to use a Tag of your own with custom handling you need to call the `registerTagHandler` method, pass
 * the name of the tag and a Fully Qualified Class Name pointing to a class that implements the Tag interface.
 */
final class StandardTagFactory implements TagFactory
{
    /** PCRE regular expression matching a tag name. */
<<<<<<< HEAD
    const REGEX_TAGNAME = '[\w\-\_\\\\]+';

    /**
     * @var string[] An array with a tag as a key, and an FQCN to a class that handles it as an array value.
     */
    private $tagHandlerMappings = [
        'author'         => '\phpDocumentor\Reflection\DocBlock\Tags\Author',
        'covers'         => '\phpDocumentor\Reflection\DocBlock\Tags\Covers',
        'deprecated'     => '\phpDocumentor\Reflection\DocBlock\Tags\Deprecated',
        // 'example'        => '\phpDocumentor\Reflection\DocBlock\Tags\Example',
        'link'           => '\phpDocumentor\Reflection\DocBlock\Tags\Link',
        'method'         => '\phpDocumentor\Reflection\DocBlock\Tags\Method',
        'param'          => '\phpDocumentor\Reflection\DocBlock\Tags\Param',
        'property-read'  => '\phpDocumentor\Reflection\DocBlock\Tags\PropertyRead',
        'property'       => '\phpDocumentor\Reflection\DocBlock\Tags\Property',
        'property-write' => '\phpDocumentor\Reflection\DocBlock\Tags\PropertyWrite',
        'return'         => '\phpDocumentor\Reflection\DocBlock\Tags\Return_',
        'see'            => '\phpDocumentor\Reflection\DocBlock\Tags\See',
        'since'          => '\phpDocumentor\Reflection\DocBlock\Tags\Since',
        'source'         => '\phpDocumentor\Reflection\DocBlock\Tags\Source',
        'throw'          => '\phpDocumentor\Reflection\DocBlock\Tags\Throws',
        'throws'         => '\phpDocumentor\Reflection\DocBlock\Tags\Throws',
        'uses'           => '\phpDocumentor\Reflection\DocBlock\Tags\Uses',
        'var'            => '\phpDocumentor\Reflection\DocBlock\Tags\Var_',
        'version'        => '\phpDocumentor\Reflection\DocBlock\Tags\Version'
    ];

    /**
     * @var \ReflectionParameter[][] a lazy-loading cache containing parameters for each tagHandler that has been used.
     */
    private $tagHandlerParameterCache = [];

    /**
     * @var FqsenResolver
     */
=======
    public const REGEX_TAGNAME = '[\w\-\_\\\\:]+';

    /**
     * @var array<class-string<Tag>> An array with a tag as a key, and an
     *                               FQCN to a class that handles it as an array value.
     */
    private $tagHandlerMappings = [
        'author' => Author::class,
        'covers' => Covers::class,
        'deprecated' => Deprecated::class,
        // 'example'        => '\phpDocumentor\Reflection\DocBlock\Tags\Example',
        'link' => LinkTag::class,
        'method' => Method::class,
        'param' => Param::class,
        'property-read' => PropertyRead::class,
        'property' => Property::class,
        'property-write' => PropertyWrite::class,
        'return' => Return_::class,
        'see' => SeeTag::class,
        'since' => Since::class,
        'source' => Source::class,
        'throw' => Throws::class,
        'throws' => Throws::class,
        'uses' => Uses::class,
        'var' => Var_::class,
        'version' => Version::class,
    ];

    /**
     * @var array<class-string<Tag>> An array with a anotation s a key, and an
     *      FQCN to a class that handles it as an array value.
     */
    private $annotationMappings = [];

    /**
     * @var ReflectionParameter[][] a lazy-loading cache containing parameters
     *      for each tagHandler that has been used.
     */
    private $tagHandlerParameterCache = [];

    /** @var FqsenResolver */
>>>>>>> ThomasN
    private $fqsenResolver;

    /**
     * @var mixed[] an array representing a simple Service Locator where we can store parameters and
     *     services that can be inserted into the Factory Methods of Tag Handlers.
     */
    private $serviceLocator = [];

    /**
     * Initialize this tag factory with the means to resolve an FQSEN and optionally a list of tag handlers.
     *
     * If no tag handlers are provided than the default list in the {@see self::$tagHandlerMappings} property
     * is used.
     *
<<<<<<< HEAD
     * @param FqsenResolver $fqsenResolver
     * @param string[]      $tagHandlers
     *
     * @see self::registerTagHandler() to add a new tag handler to the existing default list.
     */
    public function __construct(FqsenResolver $fqsenResolver, array $tagHandlers = null)
=======
     * @see self::registerTagHandler() to add a new tag handler to the existing default list.
     *
     * @param array<class-string<Tag>> $tagHandlers
     */
    public function __construct(FqsenResolver $fqsenResolver, ?array $tagHandlers = null)
>>>>>>> ThomasN
    {
        $this->fqsenResolver = $fqsenResolver;
        if ($tagHandlers !== null) {
            $this->tagHandlerMappings = $tagHandlers;
        }

        $this->addService($fqsenResolver, FqsenResolver::class);
    }

<<<<<<< HEAD
    /**
     * {@inheritDoc}
     */
    public function create($tagLine, TypeContext $context = null)
    {
        if (! $context) {
            $context = new TypeContext('');
        }

        list($tagName, $tagBody) = $this->extractTagParts($tagLine);

        if ($tagBody !== '' && $tagBody[0] === '[') {
            throw new \InvalidArgumentException(
                'The tag "' . $tagLine . '" does not seem to be wellformed, please check it for errors'
            );
        }

        return $this->createTag($tagBody, $tagName, $context);
    }

    /**
     * {@inheritDoc}
     */
    public function addParameter($name, $value)
=======
    public function create(string $tagLine, ?TypeContext $context = null) : Tag
    {
        if (!$context) {
            $context = new TypeContext('');
        }

        [$tagName, $tagBody] = $this->extractTagParts($tagLine);

        return $this->createTag(trim($tagBody), $tagName, $context);
    }

    /**
     * @param mixed $value
     */
    public function addParameter(string $name, $value) : void
>>>>>>> ThomasN
    {
        $this->serviceLocator[$name] = $value;
    }

<<<<<<< HEAD
    /**
     * {@inheritDoc}
     */
    public function addService($service, $alias = null)
=======
    public function addService(object $service, ?string $alias = null) : void
>>>>>>> ThomasN
    {
        $this->serviceLocator[$alias ?: get_class($service)] = $service;
    }

<<<<<<< HEAD
    /**
     * {@inheritDoc}
     */
    public function registerTagHandler($tagName, $handler)
    {
        Assert::stringNotEmpty($tagName);
        Assert::stringNotEmpty($handler);
=======
    public function registerTagHandler(string $tagName, string $handler) : void
    {
        Assert::stringNotEmpty($tagName);
>>>>>>> ThomasN
        Assert::classExists($handler);
        Assert::implementsInterface($handler, StaticMethod::class);

        if (strpos($tagName, '\\') && $tagName[0] !== '\\') {
<<<<<<< HEAD
            throw new \InvalidArgumentException(
=======
            throw new InvalidArgumentException(
>>>>>>> ThomasN
                'A namespaced tag must have a leading backslash as it must be fully qualified'
            );
        }

        $this->tagHandlerMappings[$tagName] = $handler;
    }

    /**
     * Extracts all components for a tag.
     *
<<<<<<< HEAD
     * @param string $tagLine
     *
     * @return string[]
     */
    private function extractTagParts($tagLine)
    {
        $matches = [];
        if (! preg_match('/^@(' . self::REGEX_TAGNAME . ')(?:\s*([^\s].*)|$)/us', $tagLine, $matches)) {
            throw new \InvalidArgumentException(
=======
     * @return string[]
     */
    private function extractTagParts(string $tagLine) : array
    {
        $matches = [];
        if (!preg_match('/^@(' . self::REGEX_TAGNAME . ')((?:[\s\(\{])\s*([^\s].*)|$)/us', $tagLine, $matches)) {
            throw new InvalidArgumentException(
>>>>>>> ThomasN
                'The tag "' . $tagLine . '" does not seem to be wellformed, please check it for errors'
            );
        }

        if (count($matches) < 3) {
            $matches[] = '';
        }

        return array_slice($matches, 1);
    }

    /**
     * Creates a new tag object with the given name and body or returns null if the tag name was recognized but the
     * body was invalid.
<<<<<<< HEAD
     *
     * @param string  $body
     * @param string  $name
     * @param TypeContext $context
     *
     * @return Tag|null
     */
    private function createTag($body, $name, TypeContext $context)
=======
     */
    private function createTag(string $body, string $name, TypeContext $context) : Tag
>>>>>>> ThomasN
    {
        $handlerClassName = $this->findHandlerClassName($name, $context);
        $arguments        = $this->getArgumentsForParametersFromWiring(
            $this->fetchParametersForHandlerFactoryMethod($handlerClassName),
            $this->getServiceLocatorWithDynamicParameters($context, $name, $body)
        );

<<<<<<< HEAD
        return call_user_func_array([$handlerClassName, 'create'], $arguments);
=======
        try {
            $callable = [$handlerClassName, 'create'];
            Assert::isCallable($callable);
            /** @phpstan-var callable(string): ?Tag $callable */
            $tag = call_user_func_array($callable, $arguments);

            return $tag ?? InvalidTag::create($body, $name);
        } catch (InvalidArgumentException $e) {
            return InvalidTag::create($body, $name)->withError($e);
        }
>>>>>>> ThomasN
    }

    /**
     * Determines the Fully Qualified Class Name of the Factory or Tag (containing a Factory Method `create`).
     *
<<<<<<< HEAD
     * @param string  $tagName
     * @param TypeContext $context
     *
     * @return string
     */
    private function findHandlerClassName($tagName, TypeContext $context)
=======
     * @return class-string<Tag>
     */
    private function findHandlerClassName(string $tagName, TypeContext $context) : string
>>>>>>> ThomasN
    {
        $handlerClassName = Generic::class;
        if (isset($this->tagHandlerMappings[$tagName])) {
            $handlerClassName = $this->tagHandlerMappings[$tagName];
        } elseif ($this->isAnnotation($tagName)) {
            // TODO: Annotation support is planned for a later stage and as such is disabled for now
<<<<<<< HEAD
            // $tagName = (string)$this->fqsenResolver->resolve($tagName, $context);
            // if (isset($this->annotationMappings[$tagName])) {
            //     $handlerClassName = $this->annotationMappings[$tagName];
            // }
=======
            $tagName = (string) $this->fqsenResolver->resolve($tagName, $context);
            if (isset($this->annotationMappings[$tagName])) {
                $handlerClassName = $this->annotationMappings[$tagName];
            }
>>>>>>> ThomasN
        }

        return $handlerClassName;
    }

    /**
     * Retrieves the arguments that need to be passed to the Factory Method with the given Parameters.
     *
<<<<<<< HEAD
     * @param \ReflectionParameter[] $parameters
     * @param mixed[]                $locator
=======
     * @param ReflectionParameter[] $parameters
     * @param mixed[]               $locator
>>>>>>> ThomasN
     *
     * @return mixed[] A series of values that can be passed to the Factory Method of the tag whose parameters
     *     is provided with this method.
     */
<<<<<<< HEAD
    private function getArgumentsForParametersFromWiring($parameters, $locator)
    {
        $arguments = [];
        foreach ($parameters as $index => $parameter) {
            $typeHint = $parameter->getClass() ? $parameter->getClass()->getName() : null;
=======
    private function getArgumentsForParametersFromWiring(array $parameters, array $locator) : array
    {
        $arguments = [];
        foreach ($parameters as $parameter) {
            $class    = $parameter->getClass();
            $typeHint = null;
            if ($class !== null) {
                $typeHint = $class->getName();
            }

>>>>>>> ThomasN
            if (isset($locator[$typeHint])) {
                $arguments[] = $locator[$typeHint];
                continue;
            }

            $parameterName = $parameter->getName();
            if (isset($locator[$parameterName])) {
                $arguments[] = $locator[$parameterName];
                continue;
            }

            $arguments[] = null;
        }

        return $arguments;
    }

    /**
     * Retrieves a series of ReflectionParameter objects for the static 'create' method of the given
     * tag handler class name.
     *
<<<<<<< HEAD
     * @param string $handlerClassName
     *
     * @return \ReflectionParameter[]
     */
    private function fetchParametersForHandlerFactoryMethod($handlerClassName)
    {
        if (! isset($this->tagHandlerParameterCache[$handlerClassName])) {
            $methodReflection                                  = new \ReflectionMethod($handlerClassName, 'create');
=======
     * @return ReflectionParameter[]
     */
    private function fetchParametersForHandlerFactoryMethod(string $handlerClassName) : array
    {
        if (!isset($this->tagHandlerParameterCache[$handlerClassName])) {
            $methodReflection                                  = new ReflectionMethod($handlerClassName, 'create');
>>>>>>> ThomasN
            $this->tagHandlerParameterCache[$handlerClassName] = $methodReflection->getParameters();
        }

        return $this->tagHandlerParameterCache[$handlerClassName];
    }

    /**
<<<<<<< HEAD
     * Returns a copy of this class' Service Locator with added dynamic parameters, such as the tag's name, body and
     * Context.
     *
     * @param TypeContext $context The Context (namespace and aliasses) that may be passed and is used to resolve FQSENs.
     * @param string      $tagName The name of the tag that may be passed onto the factory method of the Tag class.
     * @param string      $tagBody The body of the tag that may be passed onto the factory method of the Tag class.
     *
     * @return mixed[]
     */
    private function getServiceLocatorWithDynamicParameters(TypeContext $context, $tagName, $tagBody)
    {
        $locator = array_merge(
            $this->serviceLocator,
            [
                'name'             => $tagName,
                'body'             => $tagBody,
                TypeContext::class => $context
            ]
        );

        return $locator;
=======
     * Returns a copy of this class' Service Locator with added dynamic parameters,
     * such as the tag's name, body and Context.
     *
     * @param TypeContext $context The Context (namespace and aliasses) that may be
     *  passed and is used to resolve FQSENs.
     * @param string      $tagName The name of the tag that may be
     *  passed onto the factory method of the Tag class.
     * @param string      $tagBody The body of the tag that may be
     *  passed onto the factory method of the Tag class.
     *
     * @return mixed[]
     */
    private function getServiceLocatorWithDynamicParameters(
        TypeContext $context,
        string $tagName,
        string $tagBody
    ) : array {
        return array_merge(
            $this->serviceLocator,
            [
                'name' => $tagName,
                'body' => $tagBody,
                TypeContext::class => $context,
            ]
        );
>>>>>>> ThomasN
    }

    /**
     * Returns whether the given tag belongs to an annotation.
     *
<<<<<<< HEAD
     * @param string $tagContent
     *
     * @todo this method should be populated once we implement Annotation notation support.
     *
     * @return bool
     */
    private function isAnnotation($tagContent)
=======
     * @todo this method should be populated once we implement Annotation notation support.
     */
    private function isAnnotation(string $tagContent) : bool
>>>>>>> ThomasN
    {
        // 1. Contains a namespace separator
        // 2. Contains parenthesis
        // 3. Is present in a list of known annotations (make the algorithm smart by first checking is the last part
        //    of the annotation class name matches the found tag name

        return false;
    }
}
