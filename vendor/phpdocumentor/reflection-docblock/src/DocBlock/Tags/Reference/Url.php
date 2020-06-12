<?php
<<<<<<< HEAD
=======

declare(strict_types=1);

>>>>>>> ThomasN
/**
 * This file is part of phpDocumentor.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
<<<<<<< HEAD
 *  @copyright 2010-2017 Mike van Riel<mike@phpdoc.org>
 *  @license   http://www.opensource.org/licenses/mit-license.php MIT
 *  @link      http://phpdoc.org
=======
 * @link http://phpdoc.org
>>>>>>> ThomasN
 */

namespace phpDocumentor\Reflection\DocBlock\Tags\Reference;

use Webmozart\Assert\Assert;

/**
<<<<<<< HEAD
 * Url reference used by {@see phpDocumentor\Reflection\DocBlock\Tags\See}
 */
final class Url implements Reference
{
    /**
     * @var string
     */
    private $uri;

    /**
     * Url constructor.
     */
    public function __construct($uri)
=======
 * Url reference used by {@see \phpDocumentor\Reflection\DocBlock\Tags\See}
 */
final class Url implements Reference
{
    /** @var string */
    private $uri;

    public function __construct(string $uri)
>>>>>>> ThomasN
    {
        Assert::stringNotEmpty($uri);
        $this->uri = $uri;
    }

<<<<<<< HEAD
    public function __toString()
=======
    public function __toString() : string
>>>>>>> ThomasN
    {
        return $this->uri;
    }
}
