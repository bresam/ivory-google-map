<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Service;

use Ivory\GoogleMap\Service\BusinessAccount;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractUnitService extends TestCase
{
    protected ClientInterface|MockObject $client;

    protected MockObject|RequestFactoryInterface $requestFactory;

    protected MockObject|SerializerInterface $serializer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->client = $this->createHttpClientMock();
        $this->requestFactory = $this->createRequestFactoryMock();
        $this->serializer = $this->createSerializerMock();
    }

    protected function createHttpClientMock(): MockObject|ClientInterface
    {
        return $this->createMock(ClientInterface::class);
    }

    protected function createRequestFactoryMock(): RequestFactoryInterface|MockObject
    {
        return $this->createMock(RequestFactoryInterface::class);
    }

    protected function createSerializerMock(): SerializerInterface|MockObject
    {
        return $this->createMock(SerializerInterface::class);
    }

    protected function createHttpRequestMock(): RequestInterface|MockObject
    {
        return $this->createMock(RequestInterface::class);
    }

    protected function createHttpResponseMock(): ResponseInterface|MockObject
    {
        return $this->createMock(ResponseInterface::class);
    }

    protected function createHttpStreamMock(): StreamInterface|MockObject
    {
        return $this->createMock(StreamInterface::class);
    }

    protected function createBusinessAccountMock(): MockObject|BusinessAccount
    {
        return $this->createMock(BusinessAccount::class);
    }
}
