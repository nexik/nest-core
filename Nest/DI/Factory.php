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

use Nest\DI\Services\Definitions\Startegy\Yaml as YamlStrategy;
use Phalcon\Di\FactoryDefault as PhalconDI;

/**
 * Nest\DI\Factory
 *
 * Factory for building Dependency Injection Containers for Phalcon Appliaction
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class Factory
{
    /**
     * Path to application directory
     *
     * @var string
     */
    private $appPath;

    /**
     * Constructor
     *
     * @param Nest\DI\Services\Definitions $strategy
     */
    public function __construct($appPath)
    {
        $this->appPath = $appPath;
    }

    public function build($type)
    {
        $di = new PhalconDI();

        $di->setShared('router', 'Nest\Router');
        $di->setShared('config', [
            'className' => 'Phalcon\Config\Adapter\Ini',
            'arguments' => [
                ['type' => 'parameter', 'value' => $this->appPath . '/config/config.ini']
            ]
        ]);
        $di->setShared('view', [
            'className' => 'Nest\View',
            'calls' => [
                [
                    'method' => 'setViewsDir',
                    'arguments' => [
                        ['type' => 'parameter', 'value' => $this->appPath . '/views']
                    ]
                ],
                [
                    'method' => 'registerVolt',
                    'arguments' => [
                        ['type' => 'parameter', 'value' => $this->appPath . '/cache/volt/'],
                        ['type' => 'parameter', 'value' => $di]
                    ]
                ]
            ]
        ]);

        return $di;
    }
}