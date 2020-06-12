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

<<<<<<< HEAD
=======
use Symfony\Component\EventDispatcher\Event;
>>>>>>> ThomasN
use Symfony\Component\EventDispatcher\LegacyEventDispatcherProxy;
use Symfony\Component\Notifier\Exception\IncompleteDsnException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Konstantin Myakshin <molodchick@gmail.com>
 * @author Fabien Potencier <fabien@symfony.com>
 *
<<<<<<< HEAD
 * @experimental in 5.0
=======
 * @experimental in 5.1
>>>>>>> ThomasN
 */
abstract class AbstractTransportFactory implements TransportFactoryInterface
{
    protected $dispatcher;
    protected $client;

    public function __construct(EventDispatcherInterface $dispatcher = null, HttpClientInterface $client = null)
    {
<<<<<<< HEAD
        $this->dispatcher = LegacyEventDispatcherProxy::decorate($dispatcher);
=======
        $this->dispatcher = class_exists(Event::class) ? LegacyEventDispatcherProxy::decorate($dispatcher) : $dispatcher;
>>>>>>> ThomasN
        $this->client = $client;
    }

    public function supports(Dsn $dsn): bool
    {
        return \in_array($dsn->getScheme(), $this->getSupportedSchemes());
    }

    /**
     * @return string[]
     */
    abstract protected function getSupportedSchemes(): array;

    protected function getUser(Dsn $dsn): string
    {
        $user = $dsn->getUser();
        if (null === $user) {
<<<<<<< HEAD
            throw new IncompleteDsnException('User is not set.');
=======
            throw new IncompleteDsnException('User is not set.', $dsn->getOriginalDsn());
>>>>>>> ThomasN
        }

        return $user;
    }

    protected function getPassword(Dsn $dsn): string
    {
        $password = $dsn->getPassword();
        if (null === $password) {
<<<<<<< HEAD
            throw new IncompleteDsnException('Password is not set.');
=======
            throw new IncompleteDsnException('Password is not set.', $dsn->getOriginalDsn());
>>>>>>> ThomasN
        }

        return $password;
    }
}
