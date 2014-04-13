<?php
/**
* This file is part of Landingi system (https://landingi.com)
*
* @link       https://landingi.com/
* @copyright  Landingi Sp. z o.o.
*/

namespace Nest\Container;

use Nest\Cache\InternalFile as Cache;
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
     * @var Cache
     */
    private $cache;

    /**
     * @var array
     */
    private $services = [];

    /**
     * @param string $cacheDir
     */
    public function __construct(ServiceParser $parser, $cacheDir)
    {
        $this->parser = $parser;
        $this->cache = new Cache($cacheDir);
    }

    /**
     * @param string $path
     * @return $this
     * @throws \Symfony\Component\Yaml\Exception\ParseException
     * @throws \Exception
     */
    public function load($path)
    {
        $services = $this->cache->get($path);

        if (null === $services) {
            $services = $this->parser->parseServices(Yaml::parse($path));
            $this->cache->set($path, $services);
        }

        $this->services = array_merge($this->services, $services);

        return $this;
    }

    public function getServices()
    {
        return $this->services;
    }
} 