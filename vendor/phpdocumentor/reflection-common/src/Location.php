<?php
<<<<<<< HEAD
=======

>>>>>>> ThomasN
declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
<<<<<<< HEAD
 * @copyright 2010-2018 Mike van Riel<mike@phpdoc.org>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
=======
>>>>>>> ThomasN
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection;

/**
 * The location where an element occurs within a file.
<<<<<<< HEAD
=======
 *
 * @psalm-immutable
>>>>>>> ThomasN
 */
final class Location
{
    /** @var int */
    private $lineNumber = 0;

    /** @var int */
    private $columnNumber = 0;

    /**
     * Initializes the location for an element using its line number in the file and optionally the column number.
     */
    public function __construct(int $lineNumber, int $columnNumber = 0)
    {
        $this->lineNumber = $lineNumber;
        $this->columnNumber = $columnNumber;
    }

    /**
     * Returns the line number that is covered by this location.
     */
<<<<<<< HEAD
    public function getLineNumber(): int
=======
    public function getLineNumber() : int
>>>>>>> ThomasN
    {
        return $this->lineNumber;
    }

    /**
     * Returns the column number (character position on a line) for this location object.
     */
<<<<<<< HEAD
    public function getColumnNumber(): int
=======
    public function getColumnNumber() : int
>>>>>>> ThomasN
    {
        return $this->columnNumber;
    }
}
