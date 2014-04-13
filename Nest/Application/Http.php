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
     * @param string $uri
     * @return void
     */
    public function run($uri = null)
    {
        echo $this
            ->handle($uri)
            ->getContent();
    }

    /**
     * @param string|null $uri
     * @return \Phalcon\Http\Response
     */
    private function handle($uri)
    {
        $this->getEventManager()->fire('application:boot', $this);

        return $this
            ->handleRouting($uri)
            ->handleView()
            ->sendResponse();
    }

    /**
     * @param string|null $uri
     * @return \Nest\Application\Http
     */
    private function handleRouting($uri)
    {
        // get rid GET parameters from URI
        $uri = explode("?", $uri)[0];

        $this->getRouter()->handle($uri);
        $this->getDispatcher()->routing($this->getRouter());

        return $this;
    }

    /**
     * @return \Nest\Application\Http
     */
    private function handleView()
    {
        $eventsManager = $this->getEventManager();
        $dispatcher    = $this->getDispatcher();
        $view          = $this->getView();

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

        return $this;
    }

    /**
     * @return \Phalcon\Http\ResponseInterface
     */
    private function sendResponse()
    {
        $this->getEventManager()->fire("application:beforeSendResponse", $this, $this->getResponse());

        return $this->getResponse()
            ->setContent($this->getView()->getContent())
            ->sendHeaders()
            ->sendCookies();
    }
}
