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

/**
 * Nest\Application\ApplicationInterface
 *
 * Interface for all appliactions
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
interface ApplicationInterface
{
    /**
     * @return string|null
     */
    public function run();

    /**
     * @return \Phalcon\Config
     */
    public function getConfig();
}
