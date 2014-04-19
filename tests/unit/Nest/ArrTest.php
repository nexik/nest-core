<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

namespace Nest;

use Codeception\TestCase\Test;
use Codeception\Specify;

/**
 * Nest\ArrTest
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ArrTest extends Test
{
    use Specify;

    public function testPaths()
    {
        $array = [
            'foo'   => 'bar',
            'multi' => [
                'first' => 'foo',
                'second' => 'bar',
            ],
            'users' => [
                'john',
                'joe',
                'sam',
            ]
        ];

        $this->specify(
            'Return null for non existed index in array',
            function () use ($array) {
                expect(Arr::path($array, 'non_existed'))->null();
            }
        );

        $this->specify(
            'Return value for given index in 1 dimension array',
            function () use ($array) {
                expect(Arr::path($array, 'foo'))->equals('bar');
            }
        );

        $this->specify(
            'Return value from given index in multi level dimension array',
            function ($path, $value) use ($array) {
                expect(Arr::path($array, $path))->equals($value);
            },
            ['examples' => [
                ['multi.first', 'foo'],
                ['multi.second', 'bar']
            ]]
        );

        $this->specify(
            'Ensures path() casts ints to actual integers for keys',
            function ($path, $value) use ($array) {
                expect(Arr::path($array, $path))->equals($value);
            },
            ['examples' => [
                ['users.0', 'john'],
                ['users.1', 'joe'],
                ['users.2', 'sam'],
            ]]
        );

        $this->specify(
            'Return null when next dimension level not exists and default value is not given',
            function () use ($array) {
                expect(Arr::path($array, 'multi.first.johny'))->null();
            }
        );
    }
} 