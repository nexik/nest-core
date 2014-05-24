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
use Nest\Registry;
use Nest\Translate\Adapter\File;

/**
 * DeveloperContext
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class UtilContext implements Context
{
    private $subject;
    private $result;

    /**
     * @Given I have Registry
     */
    public function getRegistryObject()
    {
        $this->subject =  new Registry();
    }

    /**
     * @Given /^I have Translate constructed with "([^"]*)"/
     */
    public function getTranslateAdapterFileObject($path)
    {
        $this->subject = new File($path);
    }

    /**
     * @Given I store :value with key :key
     */
    public function iStoreValueAsKey($value, $key)
    {
        $this->subject->set($key, $value);
    }

    /**
     * @When I try to get data for :key
     */
    public function iTryToGetDataForKey($key)
    {
        $this->result = $this->subject->get($key);
    }

    /**
     * @When I try to get data for :key with default :value
     */
    public function iTryToGetDataForKeyWithDefault($key, $default)
    {
        $this->result = $this->subject->get($key, $default);
    }

    /**
     * @When I will try to query :index
     */
    public function iWillQueryTranslate($index)
    {
        $this->result = $this->subject->query($index);
    }

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


}