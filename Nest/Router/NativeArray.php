<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Router;

/**
 * Nest\Router\NativeArray
 *
 * Routing based on yaml file
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class NativeArray extends \Phalcon\Mvc\Router
{
    public function __construct($path)
    {
        parent::__construct(false);

        $this->setDefaultNamespace('App\Controller');
        $routings = include $path;

        foreach ($routings as $path => $definition) {
            if (is_string($defintion)) {
                $defintion = ['map' => $definition];
            }

            $route = $this->add($path, $definition['map']);

            if (isset($definition['name'])) {
                $route->setName($definition['name']);
            }
        }
    }
}