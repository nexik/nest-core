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

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Phalcon\Config;

/**
 * spec\Nest\Container\Service\ParserArgumentSpec
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 * @mixin  \Nest\Container\Service\Parser\Argument
 */
class ArgumentSpec extends ObjectBehavior
{
    function let()
    {
        $config = new Config(['foo' => 'bar']);
        $this->beConstructedWith($config);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nest\Container\Service\Parser\Argument');
        $this->shouldImplement('Nest\Container\Service\Parser\Parser');
    }

    function it_parse_standard_value()
    {
        $argument = $this->parse('string');

        $argument['type']->shouldBeEqualTo('parameter');
        $argument['value']->shouldBeEqualTo('string');
    }

    function it_parse_config_value()
    {
        $argument = $this->parse('!foo');

        $argument['type']->shouldBeEqualTo('parameter');
        $argument['value']->shouldBeEqualTo('bar');
    }

    function it_parse_service_as_value()
    {
        $argument = $this->parse('@router');

        $argument['type']->shouldBeEqualTo('service');
        $argument['name']->shouldBeEqualTo('router');
    }
}