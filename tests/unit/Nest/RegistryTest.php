<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

namespace Nest;

use Codeception\TestCase\Test;
use Codeception\Specify;

/**
 * Nest\RegistryTest
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class RegistryTest extends Test
{
    use Specify;

    public function testRegistry()
    {
        $registry = new Registry();

        $this->specify(
            'Return null for non existed key',
            function () use ($registry)  {
                expect($registry->get('non_existed'))->null();
            }
        );

        $this->specify(
            'Return default value for non existed key if default is set',
            function () use ($registry) {
                expect($registry->get('non_existed', 'default'))->equals('default');
            }
        );

        $this->specify(
            'Return data that was stored before',
            function () use ($registry) {
                $registry->set('key', 'value');

                expect($registry->get('key'))->equals('value');
            }
        );
    }
} 