<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

namespace Nest\Application;

use Codeception\TestCase\Test;

/**
 * Nest\Application\Http
 *
 * Application Http unit tests
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class HttpTest extends Test
{
    public function testGetConfig()
    {
        $app = new HttpTestImplementation();

        $this->assertInstanceOf('Phalcon\Config', $app->getConfig());
    }

    public function testLoadConfig()
    {
        $app = new HttpTestImplementation();

        $this->assertFalse($app->getConfig()->offsetExists('foo'));
        $app->loadConfig(DATA_PATH . '/config/base.yml');
        $this->assertTrue($app->getConfig()->offsetExists('foo'));
        $this->assertEquals('bar', $app->getConfig()->get('foo'));
    }

    public function testLoadRouting()
    {
        $app = new HttpTestImplementation();

        $router = $app->getContainer()->get('router');
        $router->clear();
        $router->handle('/file/hash/file.jpg');
        $this->assertFalse($router->wasMatched());

        $app->loadRouting(DATA_PATH . '/config/routing.yml');
        $router->handle('/file/hash/file.jpg');
        $this->assertTrue($router->wasMatched());
    }
}

class HttpTestImplementation extends Http
{
    public function configure()
    {

    }
}