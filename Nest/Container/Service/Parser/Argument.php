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

use Ohanzee\Helper\Arr;
use Phalcon\Config;
use Phalcon\Text;

/**
 * Nest\Container\ServiceParser\ArgumentParser
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 */
class Argument implements Parser
{
    /**
     * @var \Phalcon\Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function parse($argument)
    {
        if (Text::startsWith($argument, '!')) {
            return [
                'type'  => 'parameter',
                'value' => Arr::path($this->config->toArray(), substr($argument, 1)),
            ];
        } elseif (Text::startsWith($argument, '@')) {
            return [
                'type'  => 'service',
                'name' => substr($argument, 1),
            ];
        } else {
            return [
                'type'  => 'parameter',
                'value' => $argument,
            ];
        }
    }
} 