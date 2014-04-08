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

/**
 * Nest\ArrTest
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class ArrTest extends Test
{
    /**
     * @dataProvider providerPath
     */
    public function testPath($array, $path, $expected)
    {
        $this->assertEquals($expected, Arr::path($array, $path));
    }

    public function providerPath()
    {
        return [
            [
                [
                    'foo' => 'bar'
                ],
                'foo',
                'bar'
            ],
            [
                [
                    'first' => [
                        'second' => 'bar'
                    ]
                ],
                'first.second',
                'bar'
            ],
            [
                [],
                'foo',
                null
            ]
        ];
    }
} 