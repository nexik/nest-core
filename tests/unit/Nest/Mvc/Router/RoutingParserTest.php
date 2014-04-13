<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Mvc\Router;

use Codeception\TestCase\Test;

/**
 * Nest\Mvc\Router\RoutingParserTest
 *
 * Unit tests for RoutingParser
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class RoutingParserTest extends Test
{
    public function testParseYaml()
    {
        $parser = new RoutingParser();
        $routes = $parser->parseFromPath(DATA_PATH . '/config/routing.yml');

        $this->assertArrayHasKey('fileDownload', $routes);
    }

    public function testParseUnsupported()
    {
        $parser = new RoutingParser();
        $routes = $parser->parseFromPath(DATA_PATH . '/config/routing.unsupported');

        $this->assertCount(0, $routes);
    }
} 