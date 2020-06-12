<?php

declare(strict_types=1);

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

use phpDocumentor\Reflection\Type;
<<<<<<< HEAD

abstract class TagWithType extends BaseTag
{
    /** @var Type */
=======
use function in_array;
use function strlen;
use function substr;
use function trim;

abstract class TagWithType extends BaseTag
{
    /** @var ?Type */
>>>>>>> ThomasN
    protected $type;

    /**
     * Returns the type section of the variable.
<<<<<<< HEAD
     *
     * @return Type
     */
    public function getType()
=======
     */
    public function getType() : ?Type
>>>>>>> ThomasN
    {
        return $this->type;
    }

<<<<<<< HEAD
    protected static function extractTypeFromBody(string $body) : array
    {
        $type = '';
        $nestingLevel = 0;
        for ($i = 0; $i < strlen($body); $i++) {
            $character = $body[$i];

            if (trim($character) === '' && $nestingLevel === 0) {
=======
    /**
     * @return string[]
     */
    protected static function extractTypeFromBody(string $body) : array
    {
        $type         = '';
        $nestingLevel = 0;
        for ($i = 0, $iMax = strlen($body); $i < $iMax; $i++) {
            $character = $body[$i];

            if ($nestingLevel === 0 && trim($character) === '') {
>>>>>>> ThomasN
                break;
            }

            $type .= $character;
            if (in_array($character, ['<', '(', '[', '{'])) {
                $nestingLevel++;
<<<<<<< HEAD
=======
                continue;
>>>>>>> ThomasN
            }

            if (in_array($character, ['>', ')', ']', '}'])) {
                $nestingLevel--;
<<<<<<< HEAD
=======
                continue;
>>>>>>> ThomasN
            }
        }

        $description = trim(substr($body, strlen($type)));

        return [$type, $description];
    }
}
