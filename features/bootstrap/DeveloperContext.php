<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;

/**
 * DeveloperContext
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class DeveloperContext implements Context
{
    protected $subject;
    protected $result;

    /**
     * @Then I will get :value
     */
    public function iWillGet($value)
    {
        expect($this->result)->toBe($value);
    }

    /**
     * @Then I will get null value
     */
    public function iWillGetNull()
    {
        expect($this->result)->toBe(null);
    }

    /**
     * @Then I will get empty array
     */
    public function iWillGetEmptyArray()
    {
        expect(is_array($this->result) && 0 === count($this->result))->toBe(true);
    }

    /**
     * @Then I will get array equal to json:
     */
    public function iWillGetArrayEqualToJson(PyStringNode $string)
    {
        expect(json_encode($this->result))->toBe($string->getRaw());
    }
}