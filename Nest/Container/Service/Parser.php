<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Container\Service;

use Nest\Container\Service\Parser\Service;

/**
 * Nest\Container\Service\Parser
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 */
class Parser
{
    private $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param $definitions
     * @return array
     */
    public function parseServices($definitions)
    {
        $services = [];

        foreach ($definitions as $name => $definition) {
            $services[$name] = $this->service->parse($definition);
        }

        return $services;
    }
} 