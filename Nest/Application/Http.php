<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

namespace Nest\Application;

use Nest\Container\ContainerFactory;
use Phalcon\Config;

/**
 * Nest\Application\Http
 *
 * Base class for web MVC application
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class Http extends \Phalcon\Mvc\Application implements ApplicationInterface
{
    /**
     * @var \Phalcon\DI
     */
    private $container;

    private $config;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->container = ContainerFactory::build();
        $this->config = new Config();
        $this->configure();
    }

    /**
     * Template Pattern to be implemented in child class
     */
    protected function configure()
    {
    }

    protected function loadConfig($path)
    {
        $this->config->merge(ConfigFactory::buildFromPath($path));
    }

    /**
     * Get dependency injection container
     *
     * @return \Phalcon\DI
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Run application and output result to the browser
     *
     * @return string
     */
    public function run()
    {
        echo $this->handle()->getContent();
    }
}
