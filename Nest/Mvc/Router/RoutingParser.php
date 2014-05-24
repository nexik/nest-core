<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Mvc\Router;

use Symfony\Component\Yaml\Parser;

/**
 * Nest\Mvc\Router\RoutingParser
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
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
     * @param Parser $yaml
     */
    public function __construct(Parser $yaml)
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
