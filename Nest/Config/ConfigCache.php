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

use Phalcon\Config;
use Symfony\Component\Filesystem\Filesystem;

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
     * @var string
     */
    private $cachePath;

    /**
     * @var ConfigFactory
     */
    private $factory;

    public function __construct(ConfigFactory $factory, $cachePath)
    {
        $this->cachePath  = $cachePath;
        $this->factory    = $factory;
        $this->config     = new Config();
    }

    public function load($file)
    {
        $config = $this->getCache($file);

        if (null === $config) {
            $config = $this->factory->buildFromPath($file);
            $this->setCache($file, $config->toArray());
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

    private function getCache($file)
    {
        $cachePath = $this->cachePath . '/' . md5($file);

        if (file_exists($cachePath)) {
            return new Config(unserialize(file_get_contents($cachePath)));
        }

        return null;
    }

    private function setCache($file, array $array)
    {
        $cachePath = $this->cachePath . '/' . md5($file);

        file_put_contents($cachePath, serialize($array));
        chmod($cachePath, 0777);
    }
} 