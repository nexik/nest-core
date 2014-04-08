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

/**
 * Nest\RegistryTest
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class RegistryTest extends Test
{
    public function testGetNonExistedKey()
    {
        $registry = new Registry();

        $this->assertNull($registry->get('non_existed'));
    }

    public function testStoringData()
    {
        $registry = new Registry();
        $registry->set('key', 'value');

        $this->assertEquals('value', $registry->get('key'));
    }

} 