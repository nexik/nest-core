<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace spec\Nest;

use PhpSpec\ObjectBehavior;

/**
 * spec\Nest\RegistrySpec
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 */
class RegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Nest\Registry');
    }

    function it_return_null_for_non_existed_key()
    {
        $this->get('non_existed')->shouldReturn(null);
    }

    function it_return_default_for_non_existed_key()
    {
        $this->get('non_existed', 'default')->shouldReturn('default');
    }

    function it_return_before_stored_data()
    {
        $this->set('key', 'value');
        $this->get('key')->shouldReturn('value');
    }
}
