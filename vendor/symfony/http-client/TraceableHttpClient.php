<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpClient;

<<<<<<< HEAD
=======
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Response\ResponseStream;
use Symfony\Component\HttpClient\Response\TraceableResponse;
>>>>>>> ThomasN
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;
use Symfony\Contracts\Service\ResetInterface;

/**
 * @author Jérémy Romey <jeremy@free-agent.fr>
 */
<<<<<<< HEAD
final class TraceableHttpClient implements HttpClientInterface, ResetInterface
=======
final class TraceableHttpClient implements HttpClientInterface, ResetInterface, LoggerAwareInterface
>>>>>>> ThomasN
{
    private $client;
    private $tracedRequests = [];

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
<<<<<<< HEAD
=======
        $content = null;
>>>>>>> ThomasN
        $traceInfo = [];
        $this->tracedRequests[] = [
            'method' => $method,
            'url' => $url,
            'options' => $options,
            'info' => &$traceInfo,
<<<<<<< HEAD
=======
            'content' => &$content,
>>>>>>> ThomasN
        ];
        $onProgress = $options['on_progress'] ?? null;

        $options['on_progress'] = function (int $dlNow, int $dlSize, array $info) use (&$traceInfo, $onProgress) {
            $traceInfo = $info;

            if (null !== $onProgress) {
                $onProgress($dlNow, $dlSize, $info);
            }
        };

<<<<<<< HEAD
        return $this->client->request($method, $url, $options);
=======
        return new TraceableResponse($this->client, $this->client->request($method, $url, $options), $content);
>>>>>>> ThomasN
    }

    /**
     * {@inheritdoc}
     */
    public function stream($responses, float $timeout = null): ResponseStreamInterface
    {
<<<<<<< HEAD
        return $this->client->stream($responses, $timeout);
=======
        if ($responses instanceof TraceableResponse) {
            $responses = [$responses];
        } elseif (!is_iterable($responses)) {
            throw new \TypeError(sprintf('"%s()" expects parameter 1 to be an iterable of TraceableResponse objects, "%s" given.', __METHOD__, get_debug_type($responses)));
        }

        return new ResponseStream(TraceableResponse::stream($this->client, $responses, $timeout));
>>>>>>> ThomasN
    }

    public function getTracedRequests(): array
    {
        return $this->tracedRequests;
    }

    public function reset()
    {
        if ($this->client instanceof ResetInterface) {
            $this->client->reset();
        }

        $this->tracedRequests = [];
    }
<<<<<<< HEAD
=======

    /**
     * {@inheritdoc}
     */
    public function setLogger(LoggerInterface $logger): void
    {
        if ($this->client instanceof LoggerAwareInterface) {
            $this->client->setLogger($logger);
        }
    }
>>>>>>> ThomasN
}
