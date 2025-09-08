<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Service\DistanceMatrix;

use Ivory\GoogleMap\Service\DistanceMatrix\DistanceMatrixService;
use Ivory\GoogleMap\Service\DistanceMatrix\Request\DistanceMatrixRequestInterface;
use Ivory\GoogleMap\Service\DistanceMatrix\Response\DistanceMatrixResponse;
use Ivory\Tests\GoogleMap\Service\AbstractUnitService;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class DistanceMatrixServiceUnitTest extends AbstractUnitService
{
    /**
     * @var DistanceMatrixService
     */
    private $service;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new DistanceMatrixService(
            $this->client,
            $this->requestFactory,
            $this->serializer
        );
    }

    public function testGeocodeWithBusinessAccount()
    {
        $request = $this->createDistanceMatrixRequestMock();
        $request
            ->expects($this->once())
            ->method('buildQuery')
            ->willReturn($query = ['foo' => 'bar']);

        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?foo=bar&signature=signature';

        $this->requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                $this->identicalTo('GET'),
                $this->identicalTo($url)
            )
            ->willReturn($httpRequest = $this->createHttpRequestMock());

        $this->client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($this->identicalTo($httpRequest))
            ->willReturn($httpResponse = $this->createHttpResponseMock());

        $httpResponse
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($httpStream = $this->createHttpStreamMock());

        $httpStream
            ->expects($this->once())
            ->method('__toString')
            ->willReturn($result = 'result');

        $this->serializer
            ->expects($this->once())
            ->method('deserialize')
            ->with(
                $this->identicalTo($result),
                $this->identicalTo(DistanceMatrixResponse::class),
            )
            ->willReturn($response = $this->createDistanceMatrixResponseMock());

        $response
            ->expects($this->once())
            ->method('setRequest')
            ->with($this->identicalTo($request));

        $businessAccount = $this->createBusinessAccountMock();
        $businessAccount
            ->expects($this->once())
            ->method('signUrl')
            ->with($this->equalTo('https://maps.googleapis.com/maps/api/distancematrix/json?foo=bar'))
            ->willReturn($url);

        $this->service->setBusinessAccount($businessAccount);

        $this->assertSame($response, $this->service->process($request));
    }

    /**
     * @return MockObject|DistanceMatrixRequestInterface
     */
    private function createDistanceMatrixRequestMock()
    {
        return $this->createMock(DistanceMatrixRequestInterface::class);
    }

    /**
     * @return MockObject|DistanceMatrixResponse
     */
    private function createDistanceMatrixResponseMock()
    {
        return $this->createMock(DistanceMatrixResponse::class);
    }
}
