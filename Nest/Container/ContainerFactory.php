<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Container;

use Phalcon\DI;

/**
 * Nest\Container\ContainerFactory
 *
 * Dependency injection container factory
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ContainerFactory 
{
    /**
     * @return \Phalcon\DI
     */
    public static function build()
    {
        return new DI();
    }

} 