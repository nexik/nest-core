<?php
/**
 * This file is part Nest Static Page application
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace spec\Nest\Container\Service;

use Nest\Container\Service\Parser\Service;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * spec\Nest\Container\ServiceParserSpec
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 * @mixin  \Nest\Container\Service\Parser
 */
class ParserSpec extends ObjectBehavior
{
    function let(Service $service)
    {
        $this->beConstructedWith($service);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nest\Container\Service\Parser');
    }

    function it_use_service_parser(Service $service)
    {
        $service->parse(Argument::any())->shouldBeCalled();
        $this->parseServices(['service']);
    }
}