<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Container\Service\Definition;

use Ohanzee\Helper\Arr;

/**
 * Nest\Container\Service\Definition
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ServiceDefinition
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @var array
     */
    private $calls = [];

    public function __construct($definition)
    {
        $this->className = $definition['className'];
        $this->arguments = Arr::get($definition, 'arguments', []);

        foreach (Arr::get($definition, 'calls', []) as $call) {
            $this->calls[] = [
                'method'    => $call[0],
                'arguments' => Arr::get($call, 1, [])
            ];
        }
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return array
     */
    public function getCalls()
    {
        return $this->calls;
    }
} 