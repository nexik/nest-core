<?php
/**
* This file is part of Landingi system (https://landingi.com)
*
* @link       https://landingi.com/
* @copyright  Landingi Sp. z o.o.
*/

namespace Nest\Container;

use Symfony\Component\Yaml\Yaml;

/**
 * Nest\Container\ServiceCache
 *
 * Cache decorator for service parser with ability to merging definitions from
 * many sources
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ServiceCache 
{
    /**
     * @var ServiceParser
     */
    private $parser;

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var array
     */
    private $services = [];

    public function __construct(ServiceParser $parser, $cacheDir)
    {
        $this->parser = $parser;
        $this->cacheDir = $cacheDir;
    }

    /**
     * @param $path
     * @return $this
     * @throws \Symfony\Component\Yaml\Exception\ParseException
     * @throws \Exception
     */
    public function load($path)
    {
        $services = $this->getCache($path);

        if (null === $services) {
            $services = $this->parser->parseServices(Yaml::parse($path));
            $this->setCache($path, $services);
        }

        $this->services = array_merge($this->services, $services);

        return $this;
    }

    public function getServices()
    {
        return $this->services;
    }

    private function getCache($path)
    {
        $cachePath = $this->cacheDir . '/services_' . md5($path);

        if (file_exists($cachePath)) {
            return unserialize(file_get_contents($cachePath));
        }

        return null;
    }

    private function setCache($path, $services)
    {
        $cachePath = $this->cacheDir . '/services_' . md5($path);

        file_put_contents($cachePath, serialize($services));
        chmod($cachePath, 0777);
    }
} 