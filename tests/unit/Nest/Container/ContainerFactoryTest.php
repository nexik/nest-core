<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Container;

use Codeception\TestCase\Test;
use Phalcon\DI;

/**
 * Nest\Container\ContainerFactoryTest
 *
 * Test for dependency injection container factory
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ContainerFactoryTest extends Test
{
    public function testContainerHasRequestService()
    {
        // Given: Container
        $container = ContainerFactory::build();

        // Then: Expect to have defined request service
        $this->assertTrue($container->has('request'));

        // Then: Expect to request service be set as shared
        $this->assertTrue($container->getService('request')->isShared());

        // Then: Expect to have request that implements Phalcon\Http\RequestInterface
        $this->assertInstanceOf('Phalcon\Http\RequestInterface', $container->get('request'));

        // Cleanup: Reset default Phalcon DI instance
        DI::reset();
    }

    public function testContainerHasResponseService()
    {
        // Given: Container
        $container = ContainerFactory::build();

        // Then: Expect to have defined request service
        $this->assertTrue($container->has('response'));

        // Then: Expect to response service be set as shared
        $this->assertTrue($container->getService('response')->isShared());

        // Then: Expect to have response that implements Phalcon\Http\ResponseInterface
        $this->assertInstanceOf('Phalcon\Http\ResponseInterface', $container->get('response'));

        // Cleanup: Reset default Phalcon DI instance
        DI::reset();
    }

    public function testContainerHasRouterService()
    {
        // Given: Container
        $container = ContainerFactory::build();

        // Then: Expect to have defined router service
        $this->assertTrue($container->has('router'));

        // Then: Expect to router service be set as shared
        $this->assertTrue($container->getService('router')->isShared());

        // Then: Expect to have router that implements Phalcon\Mvc\RouterInterface
        $this->assertInstanceOf('Phalcon\Mvc\RouterInterface', $container->get('router'));

        // Cleanup: Reset default Phalcon DI instance
        DI::reset();
    }

    public function testContainerHasDispatcherService()
    {
        // Given: Container
        $container = ContainerFactory::build();

        // Then: Expect to have defined dispatcher service
        $this->assertTrue($container->has('dispatcher'));

        // Then: Expect to dispatcher service be set as shared
        $this->assertTrue($container->getService('dispatcher')->isShared());

        // Then: Expect to have dispatcher be instance of Phalcon\Mvc\Dispatcher
        $this->assertInstanceOf('Phalcon\Mvc\Dispatcher', $container->get('dispatcher'));

        // Cleanup: Reset default Phalcon DI instance
        DI::reset();
    }

    public function testContainerHasFilesystemService()
    {
        // Given: Container
        $container = ContainerFactory::build();

        // Then: Expect to have defined filesystem service
        $this->assertTrue($container->has('filesystem'));

        // Then: Expect to filesystem service be set as shared
        $this->assertTrue($container->getService('filesystem')->isShared());

        // Then: Expect to have filesystem be instance of Symfony\Component\Filesystem\Filesystem
        $this->assertInstanceOf('Symfony\Component\Filesystem\Filesystem', $container->get('filesystem'));

        // Cleanup: Reset default Phalcon DI instance
        DI::reset();
    }

    public function testContainerHasYamlService()
    {
        // Given: Container
        $container = ContainerFactory::build();

        // Then: Expect to have defined yaml service
        $this->assertTrue($container->has('yaml'));

        // Then: Expect to yaml service be set as shared
        $this->assertTrue($container->getService('yaml')->isShared());

        // Then: Expect to have yaml be instance of Symfony\Component\Yaml\Parser
        $this->assertInstanceOf('Symfony\Component\Yaml\Parser', $container->get('yaml'));

        // Cleanup: Reset default Phalcon instance
        DI::reset();
    }
} 