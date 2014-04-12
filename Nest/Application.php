<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

namespace Nest;

use Nest\Config\ConfigCache;
use Nest\Config\ConfigFactory;
use Nest\Container\ServiceCache;
use Nest\Container\ServiceParser;
use Phalcon\Config;
use Phalcon\DI as Container;

/**
 * Nest\Application
 *
 * Abstract application with all code for managing enviroment
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
abstract class Application
{
    /**
     * Path to the application
     *
     * @var string
     */
    protected $appPath;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guessSettings();

        $this->config    = $this->buildConfig();
        $this->container = $this->buildContainer();

        $this->initializeRouting();
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return \Phalcon\Http\Response
     */
    protected function getResponse()
    {
        return $this->getContainer()->get('response');
    }

    /**
     * @return \Phalcon\Mvc\Router
     */
    protected function getRouter()
    {
        return $this->getContainer()->get('router');
    }

    /**
     * @return \Nest\Mvc\Dispatcher
     */
    protected function getDispatcher()
    {
        return $this->getContainer()->get('dispatcher');
    }

    /**
     * @return \Phalcon\Mvc\View
     */
    protected function getView()
    {
        return $this->getContainer()->get('view');
    }

    /**
     * @return \Phalcon\Events\ManagerInterface
     */
    protected function getEventManager()
    {
        return $this->getContainer()->get('eventsManager');
    }

    /**
     * Initialize application settings base on reflection
     *
     * Set Path to folder where application is run
     * Set namespace of the appliacation class
     *
     * @return string
     */
    private function guessSettings()
    {
        $reflection = new \ReflectionObject($this);

        $this->appPath = str_replace('\\', '/', dirname($reflection->getFileName()));
        $this->namespace = $reflection->getNamespaceName();
    }

    /**
     * Load application configuration
     *
     * This method first try to load it from filesystem cache
     * If cache not exists it will parse config.yml file from
     *
     * @return Config
     */
    protected function buildConfig()
    {
        $configCache = new ConfigCache(
            new ConfigFactory(),
            $this->getCachePath() . '/internal'
        );

        return $configCache
            ->load($this->getConfigPath() . '/config.yml')
            ->getConfig();
    }

    private function buildContainer()
    {
        $container = new Container();

        $container->setShared('service_container', $container);
        $container->setShared('config', $this->config);

        foreach ($this->getServices() as $name => $definition) {
            $container->setShared($name, $definition);
        }

        return $container;
    }

    private function getServices()
    {
        $serviceCache = new ServiceCache(
            new ServiceParser($this->config),
            $this->getCachePath() . '/internal'
        );

        return $serviceCache
            ->load(__DIR__ . '/../config/services.yml')
            ->load($this->getConfigPath() . '/services.yml')
            ->getServices();
    }

    protected function getConfigPath()
    {
        return $this->getResourcesPath() . '/config';
    }

    /**
     * Return path to application cache folder
     * @return string
     */
    protected function getCachePath()
    {
        return $this->getResourcesPath() . '/cache';
    }

    protected function getResourcesPath()
    {
        return $this->appPath . '/Resources';
    }


    private function initializeRouting()
    {
        $router = $this->getRouter();
        $router->setDefaultNamespace($this->namespace . '\Controller');

        $routes = $this->getContainer()
            ->get('routingParser')
            ->parseFromPath($this->getConfigPath() . '/routing.yml');

        foreach ($routes as $name => $definition) {
            $router
                ->add($definition['url'], $definition['action'])
                ->setName($name);
        }
    }

}