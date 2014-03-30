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
use Symfony\Component\Yaml\Parser as YamlParser;

/**
 * Nest\Mvc\Router\RoutingParserTest
 *
 * Unit tests for RoutingParser
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class RoutingParserTest extends Test
{
    public function testParseFromPath()
    {
        $parser = new RoutingParser(new YamlParser());
        $routes = $parser->parseFromPath(DATA_PATH . '/config/routing.yml');

        $this->assertArrayHasKey('fileDownload', $routes);
    }
} 