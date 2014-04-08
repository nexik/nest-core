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
 * Registry
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */

class Registry
{
    /**
     * @var array
     */
    private $registry = [];

    /**
     * @param      $key
     * @param null $default
     * @return null
     */
    public function get($key, $default = null)
    {
        if (isset($this->registry[$key])) {
            return $this->registry[$key];
        }

        return $default;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->registry[$key] = $value;
    }
}
