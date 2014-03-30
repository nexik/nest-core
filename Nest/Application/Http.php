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
    private $config;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(ContainerFactory::build());

        $this->config = new Config();

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

        $this->getConfig()->merge($config);
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
     * @return \Phalcon\Mvc\Router
     */
    public function getRouter()
    {
        return $this->getContainer()->get('router');
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
