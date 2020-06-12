<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Notifier\Transport;

use Symfony\Component\Notifier\Exception\UnsupportedSchemeException;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
<<<<<<< HEAD
 * @experimental in 5.0
=======
 * @experimental in 5.1
>>>>>>> ThomasN
 */
final class NullTransportFactory extends AbstractTransportFactory
{
    /**
     * @return NullTransport
     */
    public function create(Dsn $dsn): TransportInterface
    {
        if ('null' === $dsn->getScheme()) {
            return new NullTransport($this->dispatcher);
        }

        throw new UnsupportedSchemeException($dsn, 'null', $this->getSupportedSchemes());
    }

    protected function getSupportedSchemes(): array
    {
        return ['null'];
    }
}
