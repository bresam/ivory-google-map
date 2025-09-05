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

use Http\Adapter\Guzzle7\Client;
use Http\Client\Common\Plugin\ErrorPlugin as HttpErrorPlugin;
use Http\Client\Common\Plugin\HistoryPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Service\Plugin\ErrorPlugin;
use Ivory\Tests\GoogleMap\Service\Utility\Journal;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

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
     * @var HttpClient
     */
    protected $client;

    /**
     * @var Psr17Factory
     */
    protected $messageFactory;

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
        $this->messageFactory = new GuzzleMessageFactory();

        $this->client = new PluginClient(new Client(), [
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
