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

use Codeception\TestCase\Test;
use Phalcon\Config;

/**
 * Nest\Container\ServiceParserTest
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ServiceParserTest extends Test
{
    public function testBaseServiceDefinition()
    {
        $parser = new ServiceParser(new Config());

        $definition = [
            'foo' => ['className' => 'Bar']
        ];

        $services = $parser->parseServices($definition);

        $this->assertArrayHasKey('foo', $services);
        $this->assertArrayHasKey('className', $services['foo']);
        $this->assertEquals('Bar', $services['foo']['className']);
    }

    public function testServiceWithSimpleArgumentDefinition()
    {
        $parser = new ServiceParser(new Config());

        $definition = [
            'foo' => [
                'className' => 'Bar',
                'arguments' => ['foo']
            ]
        ];

        $services = $parser->parseServices($definition);

        $this->assertArrayHasKey('arguments', $services['foo']);
        $this->assertCount(1, $services['foo']['arguments']);
        $this->assertArrayHasKey('type', $services['foo']['arguments'][0]);
        $this->assertArrayHasKey('value', $services['foo']['arguments'][0]);
        $this->assertEquals('parameter', $services['foo']['arguments'][0]['type']);
        $this->assertEquals('foo', $services['foo']['arguments'][0]['value']);
    }

    public function testServiceWithServiceArgumentDefinition()
    {
        $parser = new ServiceParser(new Config());

        $definition = [
            'foo' => [
                'className' => 'Bar',
                'arguments' => ['@yaml']
            ]
        ];

        $services = $parser->parseServices($definition);

        $this->assertArrayHasKey('arguments', $services['foo']);
        $this->assertCount(1, $services['foo']['arguments']);
        $this->assertArrayHasKey('type', $services['foo']['arguments'][0]);
        $this->assertArrayHasKey('name', $services['foo']['arguments'][0]);
        $this->assertEquals('service', $services['foo']['arguments'][0]['type']);
        $this->assertEquals('yaml', $services['foo']['arguments'][0]['name']);
    }

    public function testServiceWithConfigArgumentDefinition()
    {
        $parser = new ServiceParser(new Config(['lorem' => 'ipsum']));

        $definition = [
            'foo' => [
                'className' => 'Bar',
                'arguments' => ['!lorem']
            ]
        ];

        $services = $parser->parseServices($definition);

        $this->assertArrayHasKey('arguments', $services['foo']);
        $this->assertCount(1, $services['foo']['arguments']);
        $this->assertArrayHasKey('type', $services['foo']['arguments'][0]);
        $this->assertArrayHasKey('value', $services['foo']['arguments'][0]);
        $this->assertEquals('parameter', $services['foo']['arguments'][0]['type']);
        $this->assertEquals('ipsum', $services['foo']['arguments'][0]['value']);
    }

    public function testServiceWithCallsDefinition()
    {
        $parser = new ServiceParser(new Config(['lorem' => 'ipsum']));
        $definition = [
            'foo' => [
                'className' => 'Bar',
                'calls'     => [
                    ['configure'],
                    ['configureWithParameters', ['!lorem', 'bar']],
                    ['setRequest', ['@request']],
                ]
            ]
        ];

        $services = $parser->parseServices($definition);

        $this->assertArrayHasKey('calls', $services['foo']);
        $this->assertCount(3, $services['foo']['calls']);

        $this->assertArrayHasKey('method', $services['foo']['calls'][0]);
        $this->assertEquals('configure', $services['foo']['calls'][0]['method']);
        $this->assertArrayNotHasKey('arguments', $services['foo']['calls'][0]);

        $this->assertEquals('configureWithParameters', $services['foo']['calls'][1]['method']);
        $this->assertArrayHasKey('arguments', $services['foo']['calls'][1]);
        $this->assertCount(2, $services['foo']['calls'][1]['arguments']);
        $this->assertArrayHasKey('type', $services['foo']['calls'][1]['arguments'][0]);
        $this->assertArrayHasKey('value', $services['foo']['calls'][1]['arguments'][0]);
        $this->assertEquals('ipsum', $services['foo']['calls'][1]['arguments'][0]['value']);
        $this->assertArrayHasKey('type', $services['foo']['calls'][1]['arguments'][1]);
        $this->assertArrayHasKey('value', $services['foo']['calls'][1]['arguments'][1]);
        $this->assertEquals('bar', $services['foo']['calls'][1]['arguments'][1]['value']);

        $this->assertEquals('setRequest', $services['foo']['calls'][2]['method']);
        $this->assertArrayHasKey('arguments', $services['foo']['calls'][2]);
        $this->assertCount(1, $services['foo']['calls'][2]['arguments']);
        $this->assertArrayHasKey('type', $services['foo']['calls'][2]['arguments'][0]);
        $this->assertArrayHasKey('name', $services['foo']['calls'][2]['arguments'][0]);
        $this->assertEquals('service', $services['foo']['calls'][2]['arguments'][0]['type']);
        $this->assertEquals('request', $services['foo']['calls'][2]['arguments'][0]['name']);
    }
} 