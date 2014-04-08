<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

namespace Nest\Config;

use Codeception\TestCase\Test;

/**
 * Nest\Config\ConfigCacheTest
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ConfigCacheTest extends Test
{
    private $configPath;
    private $cacheDir;
    private $cachePath;

    public function _before()
    {
        $this->cacheDir   = DATA_PATH . '/cache/internal';
        $this->configPath = DATA_PATH . '/config/base.yml';
        $this->cachePath  = $this->cacheDir . '/' . md5($this->configPath);

        if (file_exists($this->cachePath)) {
            unlink($this->cachePath);
        }
    }

    public function testCachableConfig()
    {
        $configCache = new ConfigCache(
            new ConfigFactory(),
            $this->cacheDir
        );

        $config = $configCache->load($this->configPath)->getConfig();

        $this->assertEquals('bar', $config['foo']);
        $this->assertTrue(file_exists($this->cachePath));
    }

} 