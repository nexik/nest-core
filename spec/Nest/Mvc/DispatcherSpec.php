<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace spec\Nest\Mvc;

use Phalcon\Mvc\Router;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * spec\Nest\MvcDispatcherSpec
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 * @mixin  \Nest\Mvc\Dispatcher
 */
class DispatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Nest\Mvc\Dispatcher');
    }

    function it_populate_data_by_router(Router $router)
    {
        $router->getModuleName()->willReturn('module');
        $router->getNamespaceName()->willReturn('namespace');
        $router->getControllerName()->willReturn('controller');
        $router->getActionName()->willReturn('action');
        $router->getParams()->willReturn(['param' => 'value']);

        $this->routing($router);

        $this->getModuleName()->shouldBeEqualTo('module');
        $this->getControllerName()->shouldBeEqualTo('controller');
        $this->getActionName()->shouldBeEqualTo('action');
        $this->getParams()->shouldBeArray();
        $this->getParams()->shouldHaveKey('param');
        $this->getParams()['param']->shouldBeEqualTo('value');
    }

    public function getMatchers()
    {
        return [
            'haveKey' => function($subject, $key) {
                return array_key_exists($key, $subject);
            },
        ];
    }
}