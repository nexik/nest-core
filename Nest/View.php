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

use Phalcon\Mvc\View\Engine\Volt;

/**
 * Nest\View
 *
 * View class with volt capabilities
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class View extends \Phalcon\Mvc\View
{
    public function registerVolt($compiledPath, $di)
    {
        $volt = new Volt($this, $di);
        $volt->setOptions(
            [
                'compiledPath' => $compiledPath,
                'compiledExtension' => '.php',
                'compiledSeparator' => '_',
            ]
        );

        $compiler = $volt->getCompiler();
        $this->registerEngines(['.volt' => $volt]);
    }
}