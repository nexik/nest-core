<?php
/**
* This file is part of Landingi system (https://landingi.com)
*
* @link       https://landingi.com/
* @copyright  Landingi Sp. z o.o.
*/

namespace Nest\Config\Adapter;

use Codeception\TestCase\Test;
use Symfony\Component\Yaml\Parser;

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
        $config = new Yaml(DATA_PATH . '/config/base.yml', new Parser());

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('bar', $config->get('foo'));

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('foo', $config->section->bar);
    }
} 