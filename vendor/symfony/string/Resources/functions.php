<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\String;

<<<<<<< HEAD
/**
 * @experimental in 5.0
 */
=======
>>>>>>> ThomasN
function u(string $string = ''): UnicodeString
{
    return new UnicodeString($string);
}

<<<<<<< HEAD
/**
 * @experimental in 5.0
 */
=======
>>>>>>> ThomasN
function b(string $string = ''): ByteString
{
    return new ByteString($string);
}
<<<<<<< HEAD
=======

/**
 * @return UnicodeString|ByteString
 */
function s(string $string): AbstractString
{
    return preg_match('//u', $string) ? new UnicodeString($string) : new ByteString($string);
}
>>>>>>> ThomasN
