<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

namespace Nest\Mvc\Router;

use Symfony\Component\Yaml\Yaml;

/**
 * Nest\Mvc\Router\RoutingParser
 *
 * Description
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class RoutingParser 
{
    public function parseFromPath($path)
    {
        switch ($this->getExtension($path)) {
            case 'yml':
                return Yaml::parse($path);
            default:
                return [];
        }
    }

    /**
     * get file extension from path to file
     *
     * @param $path
     * @return string
     */
    private function getExtension($path)
    {
        return pathinfo($path)['extension'];
    }
} 