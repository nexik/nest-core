<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

use Behat\Behat\Context\SnippetAcceptingContext;
use Nest\Mvc\Router\RoutingParser;
use Symfony\Component\Yaml\Parser;

/**
 * DeveloperContext
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class MvcContext extends DeveloperContext implements SnippetAcceptingContext
{
    protected $subject;
    protected $result;

    /**
     * @Given I have Routing Parser
     */
    public function iHaveRoutingParser()
    {
        $this->subject = new RoutingParser(new Parser());
    }

    /**
     * @When I try parse routing :path
     */
    public function iTryParseRouting($path)
    {
        $this->result = $this->subject->parseFromPath($path);
    }
}
