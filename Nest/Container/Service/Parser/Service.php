<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Container\Service\Parser;

use Nest\Container\Service\Definition\ServiceDefinition;

/**
 * Nest\Container\Service\Parser\Service
 *
 * @author Tomasz Ślązok <tomek@sbaki.pl>
 */
class Service implements Parser
{
    /**
     * @var Argument
     */
    private $argument;

    /**
     * Constructor
     *
     * @param Argument $argument
     * @param Call     $call
     */
    public function __construct(Argument $argument, Call $call)
    {
        $this->argument = $argument;
        $this->call     = $call;
    }

    public function parse($definition)
    {
        $service = new ServiceDefinition($definition);
        $definition = ['className' => $service->getClassName()];

        foreach ($service->getArguments() as $argument) {
            $definition['arguments'][] = $this->argument->parse($argument);
        }

        foreach ($service->getCalls() as $call) {
            $definition['calls'][] = $this->call->parse($call);
        }

        return $definition;
    }
} 