<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */

namespace Nest\Translate\Adapter;

use Codeception\TestCase\Test;
use Codeception\Specify;

/**
 * Nest\Translate\Adapter\FileTest
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class FileTest extends Test
{
    use Specify;

    public function testFileAdapter()
    {
        $translate = new File(DATA_PATH . '/i18n/en.php');

        $this->specify(
            'Adapter will load translations from php file that return array with key, value pairs',
            function () use ($translate) {
                expect($translate->query('word.hello'))->equals('hello');
            }
        );
    }
} 