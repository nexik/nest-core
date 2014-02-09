<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Router;

use Phalcon\Config\Adapter\Yaml as ConfigYaml;

/**
 * Nest\Router\Yaml
 *
 * Routing based on yaml file
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class Yaml extends \Phalcon\Mvc\Router
{
    public function __construct($path)
    {
        parent::__construct(false);

        $this->setDefaultNamespace('App\Controller');

        foreach (new ConfigYaml($path) as $name => $routing) {
            $this
                ->add($routing->url, $routing->map)
                ->setName($name);
        }
    }
}