<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Container\Service\Parser;

/**
 * Interface Parser
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 */
interface Parser
{
    public function parse($definition);
} 