<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace spec\Nest\Mvc\Router;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Yaml\Parser;

/**
 * spec\Nest\Mvc\RouterRoutingParserSpec
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 * @mixin  \Nest\Mvc\Router\RoutingParser
 */
class RoutingParserSpec extends ObjectBehavior
{
    function let(Parser $yaml)
    {
        $this->beConstructedWith($yaml);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nest\Mvc\Router\RoutingParser');
    }

    function it_return_empty_array_for_unsupported_files()
    {
        $routes = $this->parseFromPath('routing.txt');
        $routes->shouldBeArray();
        $routes->shouldHaveCount(0);
    }

    function it_use_yaml_parser_for_yml_files(Parser $yaml)
    {
        $yaml->parse(Argument::cetera())->shouldBeCalled();

        $this->parseFromPath('fixtures/routing/routing.yml');
    }
}