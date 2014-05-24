<?php
namespace Codeception\Module;

use Codeception\Module;
use Codeception\PHPUnit\AssertWrapper;
use Closure;

class DevHelper extends Module
{
    private $testSubject;

    /**
     * @param callable $callable
     * @param array    $params
     * @return \Codeception\Module\Result
     */
    public function specify(Closure $callable, $params = [])
    {
        $test = $callable->bindTo($this->getTestSubject());

        return new Result(call_user_func_array($test, $params));
    }

    public function getTestSubject()
    {
        return $this->testSubject;
    }

    public function setTestSubject($subject)
    {
        $this->testSubject = $subject;

        return $this;
    }
}

class Result extends AssertWrapper
{
    public function __construct($result)
    {
        $this->result = $result;
    }

    public function shouldReturn($value)
    {
        $this->assert(array('Equals', $this->result, $value));
    }
}