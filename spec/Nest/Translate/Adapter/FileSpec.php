<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace spec\Nest\Translate\Adapter;

use PhpSpec\ObjectBehavior;

/**
 * spec\Nest\Translate\Adapter\FileSpec
 *
 * Description
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 */
class FileSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(__DIR__ . '/../../../../fixtures/i18n/en.php');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nest\Translate\Adapter\File');
    }

    function it_return_translations_from_file()
    {
        $this->query('hello')->shouldReturn('Hello');
    }
}
