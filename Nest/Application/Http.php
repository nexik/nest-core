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
     * @var \Phalcon\Config
     */
    private $config;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(ContainerFactory::build());

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
        $configFactory = $this->getContainer()->get('configFactory');
        $config = $configFactory->buildFromPath($path);

        $this->getConfig()->merge($config);
    }

    /**
     * Get dependency injection container
     *
     * @return \Phalcon\DI
     */
    public function getContainer()
    {
        return $this->getDI();
    }

    /**
     * @return \Phalcon\Config
     */
    public function getConfig()
    {
        return $this->config;
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
