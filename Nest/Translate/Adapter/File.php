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

use Phalcon\Translate\Adapter\NativeArray;

class File extends NativeArray
{
    public function __construct($file)
    {
        parent::__construct(['content' => include $file]);
    }
}
