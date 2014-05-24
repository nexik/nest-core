<?php
/**
 * This file is part Nest Static Page application
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace spec\Nest\Container\Service\Parser;

use Phalcon\Config;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * spec\Nest\Container\Service\ParserServiceSpec
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 * @mixin  \Nest\Container\Service\Parser\Service
 */
class ServiceSpec extends ObjectBehavior
{
    function let()
    {
        $argument = new \Nest\Container\Service\Parser\Argument(new Config(['foo' => 'bar']));
        $call     = new \Nest\Container\Service\Parser\Call($argument);

        $this->beConstructedWith($argument, $call);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nest\Container\Service\Parser\Service');
    }

    function it_parse_service()
    {
        $definition = [
            'className' => 'serviceName',
            'arguments' => ['string', '!foo', '@router'],
            'calls'     => [
                ['initialize'],
                ['setDebug', [true]]
            ]
        ];

        $service = $this->parse($definition);
        $service['className']->shouldBeEqualTo('serviceName');
        $service['arguments'][0]['type']->shouldBeEqualTo('parameter');
        $service['arguments'][0]['value']->shouldBeEqualTo('string');
        $service['arguments'][1]['type']->shouldBeEqualTo('parameter');
        $service['arguments'][1]['value']->shouldBeEqualTo('bar');
        $service['arguments'][2]['type']->shouldBeEqualTo('service');
        $service['arguments'][2]['name']->shouldBeEqualTo('router');
        $service['calls'][0]['method']->shouldBeEqualTo('initialize');
        $service['calls'][0]['arguments']->shouldBeArray();
        $service['calls'][0]['arguments']->shouldHaveCount(0);
        $service['calls'][1]['method']->shouldBeEqualTo('setDebug');
        $service['calls'][1]['arguments'][0]['type']->shouldBeEqualTo('parameter');
        $service['calls'][1]['arguments'][0]['value']->shouldBeEqualTo(true);
    }
}