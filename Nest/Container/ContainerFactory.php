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
     * @return \Phalcon\DI
     */
    public static function build()
    {
        $container = new DI();

        $container->setShared('dispatcher', 'Phalcon\Mvc\Dispatcher');
        $container->setShared('request', 'Phalcon\Http\Request');
        $container->setShared('response', 'Phalcon\Http\Response');
        $container->setShared('router', 'Nest\Router');
        $container->setShared('filesystem', 'Symfony\Component\Filesystem\Filesystem');
        $container->setShared('yaml', 'Symfony\Component\Yaml\Parser');

        return $container;
    }

} 