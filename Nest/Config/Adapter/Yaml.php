<?php
/**
* This file is part of Landingi system (https://landingi.com)
*
* @link       https://landingi.com/
* @copyright  Landingi Sp. z o.o.
*/

namespace Nest\Config\Adapter;

use Phalcon\Config;
use Symfony\Component\Yaml\Parser;

/**
 * Nest\Config\Adapter\Yaml
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class Yaml extends Config
{
    public function __construct($path, Parser $parser)
    {
        parent::__construct($parser->parse(file_get_contents($path)));
    }
} 