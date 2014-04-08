<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

namespace Nest\Config\Adapter;

use Codeception\TestCase\Test;

/**
 * Nest\Config\Adapter\YamlTest
 *
 * Description
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class YamlTest extends Test
{
    public function testConstructor()
    {
        // Given: Yaml config from _data/config/base.yml
        $config = new Yaml(DATA_PATH . '/config/base.yml');

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('bar', $config->get('foo'));

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('foo', $config->section->bar);
    }
} 