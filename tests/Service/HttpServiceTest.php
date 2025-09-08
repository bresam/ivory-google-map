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

use Ivory\GoogleMap\Service\AbstractHttpService;
use Ivory\GoogleMap\Service\AbstractService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class HttpServiceTest extends TestCase
{
    private MockObject|AbstractHttpService $service;
    private string $url;
    private ClientInterface|MockObject $client;
    private MockObject|RequestFactoryInterface $requestFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->service = $this->getMockBuilder(AbstractHttpService::class)
            ->setConstructorArgs([
                $this->url = 'https://foo',
                $this->client = $this->createHttpClientMock(),
                $this->requestFactory = $this->createRequestFactoryMock(),
            ])
            ->getMockForAbstractClass();
    }

    public function testDefaultState()
    {
        $this->assertInstanceOf(AbstractService::class, $this->service);
        $this->assertSame('https://foo', $this->service->getUrl());
        $this->assertSame($this->client, $this->service->getClient());
        $this->assertSame($this->requestFactory, $this->service->getRequestFactory());
    }

    public function testClient()
    {
        $this->service->setClient($client = $this->createHttpClientMock());

        $this->assertSame($client, $this->service->getClient());
    }

    public function testRequestFactory()
    {
        $this->service->setRequestFactory($requestFactory = $this->createRequestFactoryMock());

        $this->assertSame($requestFactory, $this->service->getRequestFactory());
    }

    private function createHttpClientMock(): ClientInterface|MockObject
    {
        return $this->createMock(ClientInterface::class);
    }

    private function createRequestFactoryMock(): RequestFactoryInterface|MockObject
    {
        return $this->createMock(RequestFactoryInterface::class);
    }
}
