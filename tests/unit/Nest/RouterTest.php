<?php
namespace Nest;

use Codeception\Util\Stub;

class RouterTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    public function testAddResourceNamespacePrefix()
    {
        $router = new Router();
        $this->assertNull($router->getResources());

        $router->addResource('Index');
        $resources = $router->getResources();
        $this->assertCount(1, $resources);

        $this->assertEquals('App\Controller\Index', $resources[0][1]);
    }
}
