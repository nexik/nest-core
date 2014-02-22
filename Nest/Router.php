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

/**
 * Nest\Router
 *
 * Router with basic functionality
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class Router extends \Phalcon\Mvc\Router
{
    public function __construct($defaultRoutes = true)
    {
        parent::__construct($defaultRoutes);
        $this->setDefaultNamespace('App\Controller');
        $this->configure();
    }

    /**
     * configure all routings in one place
     *
     * template method to be defined
     *
     * @return void
     */
    protected function configure()
    {

    }
}