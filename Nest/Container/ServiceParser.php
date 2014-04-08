<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Container;

use Nest\Arr;
use Phalcon\Config;
use Phalcon\Text;
use Symfony\Component\Yaml\Yaml;

/**
 * Nest\Container\ServiceParser
 *
 * Dependency injection container factory
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ServiceParser
{
    /**
     * @var \Phalcon\Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param $definitions
     * @return array
     */
    public function parseServices($definitions)
    {
        $services = [];

        foreach ($definitions as $name => $definition) {
            $services[$name] = $this->parseDefinition($definition);
        }

        return $services;
    }

    private function parseDefinition($definition)
    {
        if (is_array($definition)) {
            $parsedDefinition = ['className' => $definition['className']];

            if (isset($definition['arguments'])) {
                foreach ($definition['arguments'] as $value) {
                    $parsedDefinition['arguments'][] = $this->parseDefinitionArgument($value);
                }
            }

            if (isset($definition['calls'])) {
                foreach($definition['calls'] as $call) {
                    $parsedDefinition['calls'][] = $this->parseCallDefinition($call);
                }
            }

            return $parsedDefinition;
        } else {
            return $definition;
        }
    }

    private function parseCallDefinition($call)
    {
        $definition = ['method' => $call[0]];

        if (isset($call[1])) {
            foreach ($call[1] as $argument) {
                $definition['arguments'][] = $this->parseDefinitionArgument($argument);
            }
        }

        return $definition;
    }

    private function parseDefinitionArgument($argument)
    {
        if (Text::startsWith($argument, '!')) {
            return [
                'type'  => 'parameter',
                'value' => Arr::path($this->config->toArray(), substr($argument, 1)),
            ];
        } elseif (Text::startsWith($argument, '@')) {
            return [
                'type'  => 'service',
                'name' => substr($argument, 1),
            ];
        } else {
            return [
                'type'  => 'parameter',
                'value' => $argument,
            ];
        }
    }
} 