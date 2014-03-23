<?php
/**
* This file is part of Landingi system (https://landingi.com)
*
* @link       https://landingi.com/
* @copyright  Landingi Sp. z o.o.
*/
namespace Nest\Config;

use Phalcon\Config;
use Phalcon\Config\Adapter\Ini as IniAdapter;
use Phalcon\Config\Adapter\Json as JsonAdapter;
use Phalcon\Config\Adapter\Php as PhpAdapter;
use Nest\Config\Adapter\Yaml as YamlAdapter;
use Symfony\Component\Yaml\Parser as Yaml;

/**
 * Nest\Config\ConfigFactory
 *
 * Description
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ConfigFactory 
{
    public function __construct(Yaml $yaml)
    {
        $this->yaml = $yaml;
    }

    public function buildFromPath($path)
    {
        switch ($this->getExtension($path)) {
            case 'ini':
                return new IniAdapter($path);
            case 'json':
                return new JsonAdapter($path);
            case 'php':
                return new PhpAdapter($path);
            case 'yml':
                return new YamlAdapter($path, $this->yaml);
            default:
                return new Config();
        }
    }

    private function getExtension($path)
    {
        return pathinfo($path)['extension'];
    }
} 