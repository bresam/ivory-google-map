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

use Http\Client\Common\Plugin\ErrorPlugin as HttpErrorPlugin;
use Http\Client\Common\Plugin\HistoryPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\PluginClient;
use Ivory\GoogleMap\Service\Plugin\ErrorPlugin;
use Ivory\Tests\GoogleMap\Service\Utility\Journal;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Psr18Client;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class AbstractFunctionalService extends TestCase
{
    /**
     * @var Journal
     */
    protected static $journal;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * @var CacheItemPoolInterface
     */
    protected $pool;

    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass(): void
    {
        if (null === self::$journal) {
            self::$journal = new Journal();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        if (isset($_SERVER['CACHE_RESET']) && $_SERVER['CACHE_RESET']) {
            sleep(2);
        }

        $this->pool = new FilesystemAdapter('', 0, $_SERVER['CACHE_PATH']);
        $this->requestFactory = new Psr17Factory();

        $this->client = new PluginClient(new Psr18Client(new MockHttpClient()), [
            new RetryPlugin([
                'retries'         => 5,
                'exception_delay' => static function () {
                    return 1000000;
                },
                'exception_decider' => static function (RequestInterface $response, \Exception $e) {
                    return 'INVALID_REQUEST' === $e->getMessage();
                },
            ]),
            new HttpErrorPlugin(),
            new ErrorPlugin(),
            new HistoryPlugin(self::$journal),
        ]);
    }

    protected function getDateTime(string $key, string $value = 'now'): \DateTime
    {
        $item = $this->pool->getItem(sha1(__CLASS__ .'::'.$key));

        if (!$item->isHit()) {
            $item->set(new \DateTime($value));
            $this->pool->save($item);
        }

        return $item->get();
    }
}
