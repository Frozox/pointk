<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Notifier\Messenger;

use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Transport\TransportInterface;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
<<<<<<< HEAD
 * @experimental in 5.0
=======
 * @experimental in 5.1
>>>>>>> ThomasN
 */
final class MessageHandler
{
    private $transport;

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function __invoke(MessageInterface $message)
    {
        $this->transport->send($message);
    }
}
