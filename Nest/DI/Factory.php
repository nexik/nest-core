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

        if ('Mysql' === $di->get('config')->db->adapter) {
            $di->setShared('db', [
                'className' => 'Nest\Db\Adapter\Pdo\Mysql',
                'arguments' => [
                    ['type' => 'service', 'name' => 'config']
                ]
            ]);
        }

        $di->setShared('session', [
            'className' => 'Nest\Session\Adapter\Db',
            'arguments' => [
                ['type' => 'service', 'name' => 'db'],
                ['type' => 'service', 'name' => 'config']
            ],
        ]);

        $di->setShared('volt', [
            'className' => 'Phalcon\Mvc\View\Engine\Volt',
            'arguments' => [
                ['type' => 'service', 'name' => 'view'],
                ['type' => 'parameter', 'value' => $di]
            ],
            'calls' => [
                [
                    'method' => 'setOptions',
                    'arguments' => [
                        [
                            'type' => 'parameter',
                            'value' => [
                                'compiledPath' => sprintf('%s/cache/volt/', $path),
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $di->setShared('view', [
            'className' => 'Phalcon\Mvc\View',
            'calls' => [
                [
                    'method' => 'setViewsDir',
                    'arguments' => [
                        ['type' => 'parameter', 'value' => $path . '/views/']
                    ]
                ],
                [
                    'method' => 'registerEngines',
                    'arguments' => [
                        ['type' => 'parameter', 'value' => ['.volt' => 'volt']]
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
