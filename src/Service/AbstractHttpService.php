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

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;

abstract class AbstractHttpService extends AbstractService
{
    private ClientInterface $client;
    private RequestFactoryInterface $requestFactory;

    public function __construct(string $url, ClientInterface $client, RequestFactoryInterface $requestFactory)
    {
        parent::__construct($url);

        $this->setClient($client);
        $this->setRequestFactory($requestFactory);
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    public function getRequestFactory(): RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    public function setRequestFactory(RequestFactoryInterface $requestFactory): void
    {
        $this->requestFactory = $requestFactory;
    }

    protected function createRequest(RequestInterface $request): PsrRequestInterface
    {
        return $this->requestFactory->createRequest('GET', $this->createUrl($request));
    }
}
