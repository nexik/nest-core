<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Container;

use Nest\Cache\InternalFile as Cache;
use Nest\Container\Service\Parser;
use Symfony\Component\Yaml\Yaml;

/**
 * Nest\Container\ServiceCache
 *
 * Cache decorator for service parser with ability to merging definitions from
 * many sources
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 */
class ServiceCache 
{
    /**
     * @var Service\Parser
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
     * @param Service\Parser $parser
     * @param string         $cacheDir
     */
    public function __construct(Parser $parser, $cacheDir)
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