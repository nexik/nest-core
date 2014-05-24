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
 * spec\Nest\Container\Service\ParserCallSpec
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 * @mixin  \Nest\Container\Service\Parser\Call
 */
class CallSpec extends ObjectBehavior
{
    function let()
    {
        $argument = new \Nest\Container\Service\Parser\Argument(new Config(['foo' => 'bar']));

        $this->beConstructedWith($argument);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nest\Container\Service\Parser\Call');
        $this->shouldImplement('Nest\Container\Service\Parser\Parser');
    }

    function it_parse_simple_without_arguments()
    {
        $call = $this->parse(['method' => 'initialize', 'arguments' => []]);
        $call['method']->shouldBeEqualTo('initialize');
        $call['arguments']->shouldBeArray();
        $call['arguments']->shouldHaveCount(0);
    }

    function it_parse_call_with_one_argument()
    {
        $call = $this->parse(['method' => 'initialize', 'arguments' => ['string']]);

        $call['method']->shouldBeEqualTo('initialize');
        $call['arguments'][0]['type']->shouldBeEqualTo('parameter');
        $call['arguments'][0]['value']->shouldBeEqualTo('string');
    }

    function it_parse_call_with_many_arguments()
    {
        $call = $this->parse(['method' => 'initialize', 'arguments' => ['string', '!foo']]);

        $call['method']->shouldBeEqualTo('initialize');
        $call['arguments'][0]['type']->shouldBeEqualTo('parameter');
        $call['arguments'][0]['value']->shouldBeEqualTo('string');
        $call['arguments'][1]['type']->shouldBeEqualTo('parameter');
        $call['arguments'][1]['value']->shouldBeEqualTo('bar');
    }
}