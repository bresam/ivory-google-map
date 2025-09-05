<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Service;

use Http\Client\HttpClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractHttpService extends AbstractService
{
    private HttpClient $client;
    private Psr17Factory $messageFactory;

    public function __construct(string $url, HttpClient $client, Psr17Factory $messageFactory)
    {
        parent::__construct($url);

        $this->setClient($client);
        $this->setMessageFactory($messageFactory);
    }

    /**
     * @return HttpClient
     */
    public function getClient()
    {
        return $this->client;
    }
    /**
     * @return void
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return Psr17Factory
     */
    public function getMessageFactory()
    {
        return $this->messageFactory;
    }
    /**
     * @return void
     */
    public function setMessageFactory(Psr17Factory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }

    /**
     * @return PsrRequestInterface
     */
    protected function createRequest(RequestInterface $request)
    {
        return $this->messageFactory->createRequest('GET', $this->createUrl($request));
    }
}
