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


class RouterTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $codeGuy;

    public function testAddResourceNamespacePrefix()
    {
        // Given: Router object without any resources
        $router = new Router();
        $this->assertNull($router->getResources());

        // When: Added Index Resource
        $router->addResource('Index');

        // Then: Expect to have 1 resource with exactly App\Controller\Index
        $resources = $router->getResources();
        $this->assertCount(1, $resources);
        $this->assertEquals('App\Controller\Index', $resources[0][1]);
    }
}
