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

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * spec\Nest\Container\ServiceDefinitionSpec
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 * @mixin  \Nest\Container\Service\Definition
 */
class DefinitionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([
            'className' => 'MyClass',
            'arguments' => ['foo', 'bar'],
            'calls'     => ['magiccall']
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nest\Container\Service\Definition\ServiceDefinition');
    }

    function it_store_class_name()
    {
        $this->getClassName()->shouldBeEqualTo('MyClass');
    }

    function it_store_arguments()
    {
        $arguments = $this->getArguments();

        $arguments->shouldBeArray();
        $arguments->shouldHaveCount(2);
        $arguments[0]->shouldBeEqualTo('foo');
        $arguments[1]->shouldBeEqualTo('bar');
    }

    function it_store_calls()
    {
        $calls = $this->getCalls();

        $calls->shouldBeArray();
        $calls->shouldHaveCount(1);
        $calls[0]->shouldBeEqualTo('magiccall');
    }
}