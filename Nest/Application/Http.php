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

use Nest\Container\ContainerFactory;
use Phalcon\Config;
use Nest\Application;

/**
 * Nest\Application\Http
 *
 * Base class for web MVC application
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class Http extends Application implements ApplicationInterface
{
    /**
     * Run application and output result to the browser
     *
     * @return string
     */
    public function run()
    {
        echo $this->handle()->getContent();
    }

    private function handle()
    {
        $eventsManager = $this->getContainer()->get('eventsManager');
        $dispatcher    = $this->getContainer()->get('dispatcher');
        $router        = $this->getContainer()->get('router');
        $view          = $this->getContainer()->get('view');

        $eventsManager->fire('application:boot', $this);

        $router->handle();
        $dispatcher->routing($router);

        $view->start();

        $eventsManager->fire('application:beforeHandleRequest', $this, $dispatcher);
        $controller = $dispatcher->dispatch();

        $eventsManager->fire('application:afterHandleRequest', $this, $controller);

        if (is_object($controller)) {
            $eventsManager->fire("application:viewRender", $this, $view);

            $view->render(
                $dispatcher->getControllerName(),
                $dispatcher->getActionName(),
                $dispatcher->getParams()
            );
        }

        $view->finish();

        $response = $this->getResponse();

        $eventsManager->fire("application:beforeSendResponse", $this, $response);

        return $response
            ->setContent($view->getContent())
            ->sendHeaders()
            ->sendCookies();
    }
}
