<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

namespace Nest\Config;

use Phalcon\Config;
use Phalcon\Config\Adapter\Ini as IniAdapter;
use Phalcon\Config\Adapter\Json as JsonAdapter;
use Nest\Config\Adapter\Yaml as YamlAdapter;

/**
 * Nest\Config\ConfigFactory
 *
 * Description
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ConfigFactory 
{
    /**
     * @param string $path
     */
    public function buildFromPath($path)
    {
        switch ($this->getExtension($path)) {
            case 'ini':
                return new IniAdapter($path);
            case 'json':
                return new JsonAdapter($path);
            case 'yml':
                return new YamlAdapter($path);
            default:
                return new Config(require $path);
        }
    }

    private function getExtension($path)
    {
        return pathinfo($path)['extension'];
    }
} 