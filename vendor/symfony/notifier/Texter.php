<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Notifier;

<<<<<<< HEAD
=======
use Symfony\Component\EventDispatcher\Event;
>>>>>>> ThomasN
use Symfony\Component\EventDispatcher\LegacyEventDispatcherProxy;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Notifier\Event\MessageEvent;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Transport\TransportInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
<<<<<<< HEAD
 * @experimental in 5.0
=======
 * @experimental in 5.1
>>>>>>> ThomasN
 */
final class Texter implements TexterInterface
{
    private $transport;
    private $bus;
    private $dispatcher;

    public function __construct(TransportInterface $transport, MessageBusInterface $bus = null, EventDispatcherInterface $dispatcher = null)
    {
        $this->transport = $transport;
        $this->bus = $bus;
<<<<<<< HEAD
        $this->dispatcher = LegacyEventDispatcherProxy::decorate($dispatcher);
=======
        $this->dispatcher = class_exists(Event::class) ? LegacyEventDispatcherProxy::decorate($dispatcher) : $dispatcher;
>>>>>>> ThomasN
    }

    public function __toString(): string
    {
        return 'texter';
    }

    public function supports(MessageInterface $message): bool
    {
        return $this->transport->supports($message);
    }

    public function send(MessageInterface $message): void
    {
        if (null === $this->bus) {
            $this->transport->send($message);

            return;
        }

        if (null !== $this->dispatcher) {
            $this->dispatcher->dispatch(new MessageEvent($message, true));
        }

        $this->bus->dispatch($message);
    }
}
