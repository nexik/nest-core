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

use Nest\Cache\InternalFile as Cache;
use Phalcon\Config;

/**
 * Nest\Config\ConfigCache
 *
 * Description
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ConfigCache 
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var ConfigFactory
     */
    private $factory;

    /**
     * @var \Phalcon\Config
     */
    private $config;

    public function __construct(ConfigFactory $factory, $cachePath)
    {
        $this->factory   = $factory;
        $this->config    = new Config();
        $this->cache     = new Cache($cachePath);
    }

    public function load($file)
    {
        $config = $this->cache->get($file);

        if (null === $config) {
            $config = $this->factory->buildFromPath($file);
            $this->cache->set($file, $config->toArray());
        } else {
            $config = new Config($config);
        }

        if ($config) {
            $this->config->merge($config);
        }

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }
} 