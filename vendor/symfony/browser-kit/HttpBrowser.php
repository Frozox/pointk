<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\BrowserKit;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mime\Part\AbstractPart;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Component\Mime\Part\TextPart;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * An implementation of a browser using the HttpClient component
 * to make real HTTP requests.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class HttpBrowser extends AbstractBrowser
{
    private $client;

    public function __construct(HttpClientInterface $client = null, History $history = null, CookieJar $cookieJar = null)
    {
        if (!$client && !class_exists(HttpClient::class)) {
            throw new \LogicException(sprintf('You cannot use "%s" as the HttpClient component is not installed. Try running "composer require symfony/http-client".', __CLASS__));
        }

        $this->client = $client ?? HttpClient::create();

        parent::__construct([], $history, $cookieJar);
    }

<<<<<<< HEAD
    protected function doRequest($request): Response
    {
        $headers = $this->getHeaders($request);
        [$body, $extraHeaders] = $this->getBodyAndExtraHeaders($request);
=======
    /**
     * @param Request $request
     */
    protected function doRequest($request): Response
    {
        $headers = $this->getHeaders($request);
        [$body, $extraHeaders] = $this->getBodyAndExtraHeaders($request, $headers);
>>>>>>> ThomasN

        $response = $this->client->request($request->getMethod(), $request->getUri(), [
            'headers' => array_merge($headers, $extraHeaders),
            'body' => $body,
            'max_redirects' => 0,
        ]);

        return new Response($response->getContent(false), $response->getStatusCode(), $response->getHeaders(false));
    }

    /**
     * @return array [$body, $headers]
     */
<<<<<<< HEAD
    private function getBodyAndExtraHeaders(Request $request): array
=======
    private function getBodyAndExtraHeaders(Request $request, array $headers): array
>>>>>>> ThomasN
    {
        if (\in_array($request->getMethod(), ['GET', 'HEAD'])) {
            return ['', []];
        }

        if (!class_exists(AbstractPart::class)) {
            throw new \LogicException('You cannot pass non-empty bodies as the Mime component is not installed. Try running "composer require symfony/mime".');
        }

        if (null !== $content = $request->getContent()) {
<<<<<<< HEAD
=======
            if (isset($headers['content-type'])) {
                return [$content, []];
            }

>>>>>>> ThomasN
            $part = new TextPart($content, 'utf-8', 'plain', '8bit');

            return [$part->bodyToString(), $part->getPreparedHeaders()->toArray()];
        }

        $fields = $request->getParameters();

        if ($uploadedFiles = $this->getUploadedFiles($request->getFiles())) {
<<<<<<< HEAD
            $part = new FormDataPart($uploadedFiles);
=======
            $part = new FormDataPart(array_merge($fields, $uploadedFiles));
>>>>>>> ThomasN

            return [$part->bodyToIterable(), $part->getPreparedHeaders()->toArray()];
        }

        if (empty($fields)) {
            return ['', []];
        }

        return [http_build_query($fields, '', '&', PHP_QUERY_RFC1738), ['Content-Type' => 'application/x-www-form-urlencoded']];
    }

    private function getHeaders(Request $request): array
    {
        $headers = [];
        foreach ($request->getServer() as $key => $value) {
            $key = strtolower(str_replace('_', '-', $key));
            $contentHeaders = ['content-length' => true, 'content-md5' => true, 'content-type' => true];
            if (0 === strpos($key, 'http-')) {
                $headers[substr($key, 5)] = $value;
            } elseif (isset($contentHeaders[$key])) {
                // CONTENT_* are not prefixed with HTTP_
                $headers[$key] = $value;
            }
        }
        $cookies = [];
        foreach ($this->getCookieJar()->allRawValues($request->getUri()) as $name => $value) {
            $cookies[] = $name.'='.$value;
        }
        if ($cookies) {
            $headers['cookie'] = implode('; ', $cookies);
        }

        return $headers;
    }

    /**
     * Recursively go through the list. If the file has a tmp_name, convert it to a DataPart.
     * Keep the original hierarchy.
     */
    private function getUploadedFiles(array $files): array
    {
        $uploadedFiles = [];
        foreach ($files as $name => $file) {
            if (!\is_array($file)) {
                return $uploadedFiles;
            }
            if (!isset($file['tmp_name'])) {
                $uploadedFiles[$name] = $this->getUploadedFiles($file);
            }
            if (isset($file['tmp_name'])) {
                $uploadedFiles[$name] = DataPart::fromPath($file['tmp_name'], $file['name']);
            }
        }

        return $uploadedFiles;
    }
}
