<?php
/**
* This file is part of Landingi system (https://landingi.com)
*
* @link       https://landingi.com/
* @copyright  Landingi Sp. z o.o.
*/

namespace Nest\Mvc\Router;

use Symfony\Component\Yaml\Parser as Yaml;

/**
 * Nest\Mvc\Router\RoutingParser
 *
 * Description
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class RoutingParser 
{
    /**
     * @var \Symfony\Component\Yaml\Parser
     */
    private $yaml;

    /**
     * Constructor
     *
     * @param Yaml $yaml
     */
    public function __construct(Yaml $yaml)
    {
        $this->yaml = $yaml;
    }

    public function parseFromPath($path)
    {
        switch ($this->getExtension($path)) {
            case 'yml':
                return $this->yaml->parse(file_get_contents($path));
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