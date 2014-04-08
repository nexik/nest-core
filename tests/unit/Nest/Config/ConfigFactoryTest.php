<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

namespace Nest\Config;

use Codeception\TestCase\Test;

/**
 * Nest\Config\ConfigFactoryTest
 *
 * Test for ConfigFactory
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ConfigFactoryTest extends Test
{
    public function testFactoryIni()
    {
        // Given: ConfigFactory
        $factory = new ConfigFactory();

        // Given: Config build with ConfigFactory from INI file
        $config = $factory->buildFromPath(DATA_PATH . '/config/base.ini');

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('bar', $config->get('foo'));

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('foo', $config->section->bar);
    }

    public function testFactoryYaml()
    {
        // Given: ConfigFactory
        $factory = new ConfigFactory();

        // Given: Config build with ConfigFactory from YML file
        $config = $factory->buildFromPath(DATA_PATH . '/config/base.yml');

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('bar', $config->get('foo'));

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('foo', $config->section->bar);
    }

    public function testFactoryJson()
    {
        // Given: ConfigFactory
        $factory = new ConfigFactory();

        // Given: Config build with ConfigFactory from JSON file
        $config = $factory->buildFromPath(DATA_PATH . '/config/base.json');

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('bar', $config->get('foo'));

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('foo', $config->section->bar);
    }

    public function testFactoryPhp()
    {
        // Given: ConfigFactory
        $factory = new ConfigFactory();

        // Given: Config build with ConfigFactory from PHP file
        $config = $factory->buildFromPath(DATA_PATH . '/config/base.php');

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('bar', $config->get('foo'));

        // Then: Expect to config parameter foo be equal to bar
        $this->assertSame('foo', $config->section->bar);
    }
} 