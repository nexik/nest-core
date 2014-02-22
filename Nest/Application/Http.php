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

use Nest\Application\ApplicationInterface;
use Nest\DI\Factory as DIFactory;
use Nest\DI\Services\Definitions\Strategy\Yaml as YamlStrategy;


/**
 * Nest\Application\Http
 *
 * Base class for web MVC application
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class Http extends Base implements ApplicationInterface
{
    public function __construct($appPath)
    {
        $diFactory = new DIFactory($appPath);

        parent::__construct($diFactory->build('http'));

        $this->configure();
    }

    /**
     * Run application and output result to the browser
     *
     * @return string
     */
    public function run()
    {
        echo $this->handle()->getContent();
    }
}