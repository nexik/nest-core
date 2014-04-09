<?php
/**
* This file is part of Landingi system (https://landingi.com)
*
* @link       https://landingi.com/
* @copyright  Landingi Sp. z o.o.
*/

namespace Nest\Container;

use Codeception\TestCase\Test;
use Phalcon\Config;

/**
 * Nest\Container\ServiceCacheTest
 *
 * Description
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ServiceCacheTest extends Test
{
    private $cacheDir;
    private $servicePath;

    /**
     * @var ServiceCache
     */
    private $cache;

    public function _before()
    {
        $this->cacheDir   = DATA_PATH . '/cache/internal';
        $this->servicePath = DATA_PATH . '/config/services.yml';

        if (file_exists($this->cacheDir . '/' . md5($this->servicePath))) {
            unlink($this->cacheDir . '/' . md5($this->servicePath));
        }

        $this->cache = new ServiceCache(
            new ServiceParser(new Config(['lorem' => 'ipsum'])),
            $this->cacheDir
        );

    }

    public function testGetServices()
    {
        $this->assertTrue(is_array($this->cache->getServices()));
        $this->assertCount(0, $this->cache->getServices());
    }

    public function testLoad()
    {
        $services = $this->cache
            ->load($this->servicePath)
            ->getServices();

        $this->assertCount(1, $services);
        $this->assertArrayHasKey('foo', $services);
        $this->assertFileExists($this->cacheDir . '/' . md5($this->servicePath));
    }
} 