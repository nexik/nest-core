<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\DI;

/**
 * Nest\DI\Factory
 *
 * Factory for building Dependency Injection Containers for Phalcon Applications
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class Factory
{
    public static function buildCli($appPath)
    {
        $di = new Phalcon\Di\FactoryDefault\CLI();

        return $di;
    }

    public static function buildHttp($appPath)
    {
        $di = new \Phalcon\Di\FactoryDefault();

        $di->setShared('router', 'App\Router');

        $di->setShared('config', [
            'className' => 'Phalcon\Config\Adapter\Ini',
            'arguments' => [
                ['type' => 'parameter', 'value' => $appPath . '/config/config.ini']
            ]
        ]);

        $di->setShared('view', [
            'className' => 'Nest\View',
            'calls' => [
                [
                    'method' => 'setViewsDir',
                    'arguments' => [
                        ['type' => 'parameter', 'value' => $appPath . '/views']
                    ]
                ],
                [
                    'method' => 'registerVolt',
                    'arguments' => [
                        ['type' => 'parameter', 'value' => $appPath . '/cache/volt/'],
                        ['type' => 'parameter', 'value' => $di]
                    ]
                ]
            ]
        ]);

        return $di;
    }
}
