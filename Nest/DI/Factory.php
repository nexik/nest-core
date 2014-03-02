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
    public static function buildCli($path)
    {
        $di = self::initilizeShared(new \Phalcon\Di\FactoryDefault\CLI(), $path);

        return $di;
    }

    public static function buildHttp($path)
    {
        $di = self::initilizeShared(new \Phalcon\Di\FactoryDefault(), $path);

        $di->setShared('router', 'Nest\Router');

        $di->setShared('eventsManager', [
            'className' => 'Phalcon\Events\Manager',
            'calls' => [
                [
                    'method' => 'attach',
                    'arguments' => [
                        [
                            'type' => 'parameter',
                            'value' => 'dispatch:beforeException',
                        ],
                        [
                            'type' => 'parameter',
                            'value' => function ($event, $dispatcher, $exception) {
                                switch ($exception->getCode()) {
                                    case \Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                                    case \Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                                        $dispatcher->forward([
                                           'controller' => 'App\Controller\Index',
                                           'action'     => 'error404',
                                        ]);

                                        return false;
                                }
                            }
                        ]
                    ]
                ]
            ]
        ]);

        $di->setShared('dispatcher', [
            'className' => 'Phalcon\Mvc\Dispatcher',
            'calls' => [
                [
                    'method' => 'setEventsManager',
                    'arguments' => [
                        ['type' => 'service', 'name' => 'eventsManager']
                    ]
                ]
            ]
        ]);

        $di->setShared('session', [
            'className' => 'Nest\Session\Adapter\Database',
            'arguments' => [
                ['type' => 'service', 'name' => 'db'],
                ['type' => 'service', 'name' => 'config']
            ],
        ]);

        $di->setShared('view', [
            'className' => 'Nest\View',
            'calls' => [
                [
                    'method' => 'setViewsDir',
                    'arguments' => [
                        ['type' => 'parameter', 'value' => $path . '/views']
                    ]
                ],
                [
                    'method' => 'registerVolt',
                    'arguments' => [
                        ['type' => 'parameter', 'value' => $path . '/cache/volt/'],
                        ['type' => 'parameter', 'value' => $di]
                    ]
                ]
            ]
        ]);

        return $di;
    }

    private static function initilizeShared($di, $path)
    {
        $di->setShared('config', [
            'className' => 'Phalcon\Config\Adapter\Ini',
            'arguments' => [
                ['type' => 'parameter', 'value' => $path . '/config/config.ini']
            ],
            'calls' => [
                [
                    'method' => 'merge',
                    'arguments' => [
                        [
                            'type' => 'parameter',
                            'value' => [
                                'paths' => [
                                    'app' => $path
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        return $di;
    }
}
