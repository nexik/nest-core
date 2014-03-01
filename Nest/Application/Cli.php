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
use Nest\DI\Factory;
use Symfony\Component\Console\Application as SymfonyCli;

/**
 * Nest\Application\Http
 *
 * Base class for command line applications
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
abstract class Cli extends Symfony\Component\Console\Application
{
    private $cli;

    public function __construct($appPath)
    {
        parent::__construct();

        $this->di = Factory::buildCli($appPath);
        $this->configure();
    }

    abstract public function configure();
}
