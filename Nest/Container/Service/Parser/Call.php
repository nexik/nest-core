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
* Nest\Container\Service\ParserCall
*
* @author Tomasz Ślązok <tomek@sabaki.pl>
*/
class Call implements Parser
{
    /**
     * @var Argument
     */
    private $argument;

    public function __construct(Argument $argument)
    {
        $this->argument = $argument;
    }

    public function parse($definition)
    {
        foreach ($definition['arguments'] as $key => $value) {
            $definition['arguments'][$key] = $this->argument->parse($value);
        }

        return $definition;
    }
}
