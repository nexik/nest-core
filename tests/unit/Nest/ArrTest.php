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
    public function testPath($expected, $array, $path, $default = null, $delimiter = '.')
    {
        $this->assertEquals($expected, Arr::path($array, $path, $default, $delimiter));
    }

    public function providerPath()
    {
        $array = [
            'foobar' => ['definition' => 'lost'],
            'kohana' => 'awesome',
            'users'  => [
                1 => ['name' => 'matt'],
                2 => ['name' => 'john', 'interests' => ['hocky' => ['length' => 2], 'football' => []]],
                3 => 'frank', // Issue #3194
            ]
        ];

        return [
            // Tests returns normal values
            [$array['foobar'], $array, 'foobar'],
            [$array['kohana'], $array, 'kohana'],
            [$array['foobar']['definition'], $array, 'foobar.definition'],
            // Custom delimiters
            [$array['foobar']['definition'], $array, 'foobar/definition', null, '/'],
            // We should be able to use NULL as a default, returned if the key DNX
            [null, $array, 'foobar.alternatives', null],
            [null, $array, 'kohana.alternatives', null],
            // Try using a string as a default
            ['nothing', $array, 'kohana.alternatives', 'nothing'],
            // Make sure you can use arrays as defaults
            [['far', 'wide'], $array, 'cheese.origins',  ['far', 'wide']],
            // Ensures path() casts ints to actual integers for keys
            [$array['users'][1]['name'], $array, 'users.1.name'],
            // Test that a wildcard returns the entire array at that "level"
            [$array['users'], $array, 'users.*'],
            // Now we check that keys after a wilcard will be processed
            [[0 => [0 => 2]], $array, 'users.*.interests.*.length'],
            // See what happens when it can't dig any deeper from a wildcard
            [NULL, $array, 'users.*.fans'],
            // Starting wildcards, issue #3269
            [['matt', 'john'], $array['users'], '*.name'],
            // Path as array, issue #3260
            [$array['users'][2]['name'], $array, ['users', 2, 'name']],
        ];
    }
} 