<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Mvc;

use Phalcon\Mvc\Router;

/**
 * Nest\Mvc\Dispatcher
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 */
class Dispatcher extends \Phalcon\Mvc\Dispatcher
{
    public function routing(Router $router)
    {
        $this->setModuleName($router->getModuleName());
        $this->setNamespaceName($router->getNamespaceName());
        $this->setControllerName($router->getControllerName());
        $this->setActionName($router->getActionName());
        $this->setParams($router->getParams());
    }
} 