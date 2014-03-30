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
use Phalcon\Mvc\Application;

/**
 * Nest\Application\Http
 *
 * Base class for web MVC application
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class Http extends Application implements ApplicationInterface
{
    /**
     * @var \Phalcon\Config
     */
    protected $config;

    /**
     * @var \Nest\Container\ContainerFactory
     */
    private $factory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $factory   = new ContainerFactory();
        $container = $factory->build(__DIR__ . '/../../config/services.yml');

        parent::__construct($container);

        $this->config  = new Config();
        $this->factory = $factory;

        if (method_exists($this, 'configure')) {
            $this->configure();
        }
    }

    /**
     * Load Config (merge with current one) from given path
     *
     * @param $path
     */
    public function loadConfig($path)
    {
        if ($this->getContainer()->has('cache')) {
            $cache  = $this->getContainer()->get('cache');
            $key    = sprintf('config_%s', md5($path));
            $config = $cache->get($key);

            if (null === $config) {
                $config = $this->parseConfig($path);
                $cache->save($key, $config);
            }
        } else {
            $config = $this->parseConfig($path);
        }

        $this->config->merge($config);
    }

    public function loadServices($path)
    {
        $this->factory->loadServices($this->getContainer(), $path);
    }

    private function parseConfig($path)
    {
        $configFactory = $this->getContainer()->get('configFactory');

        return $configFactory->buildFromPath($path);
    }

    /**
     * Load Routing (merge with current one) from given path
     * @param $path
     */
    public function loadRouting($path)
    {
        $parser = $this->getContainer()->get('routingParser');

        foreach ($parser->parseFromPath($path) as $name => $definition) {
            $this->getContainer()
                ->get('router')
                ->add($definition['url'], $definition['action'])
                ->setName($name);
        }
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
     * Run application and output result to the browser
     *
     * @return string
     */
    public function run()
    {
        echo $this->handle()->getContent();
    }
}
