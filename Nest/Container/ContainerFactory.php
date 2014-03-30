<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Container;

use Phalcon\DI;

/**
 * Nest\Container\ContainerFactory
 *
 * Dependency injection container factory
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ContainerFactory 
{
    /**
     * @param $path
     * @return \Phalcon\DI
     */
    public function build($path)
    {
        $container = new DI();
        $container->setShared('yaml', 'Symfony\Component\Yaml\Parser');

        return self::loadServices($container, $path);
    }

    /**
     * @param \Phalcon\DI $container
     * @param string      $path
     * @return \Phalcon\DI
     */
    public function loadServices(DI $container, $path)
    {
        if ($container->has('cache')) {
            $cache    = $container->get('cache');
            $key      = sprintf('services_defs_%s', md5($path));
            $services = $cache->get($key);

            if (null === $services) {
                $services = $this->parseServices($container, $path);
            }
        } else {
            $services = $this->parseServices($container, $path);
        }

        foreach ($services as $name => $definition) {
            $container->setShared($name, $definition);
        }

        return $container;
    }

    /**
     * @param DI     $container
     * @param string $path
     * @return array
     */
    private static function parseServices(DI $container, $path)
    {
        $parser = $container->get('yaml');
        $yaml = file_get_contents($path);

        return $parser->parse($yaml);
    }
} 