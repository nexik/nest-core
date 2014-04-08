<?php
/**
* This file is part of Landingi system (https://landingi.com)
*
* @link       https://landingi.com/
* @copyright  Landingi Sp. z o.o.
*/

namespace Nest\Mvc;

use Phalcon\Mvc\Router;

/**
 * Nest\Mvc\Dispatcher
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
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