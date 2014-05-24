<?php
/**
 * This file is part Nest Core
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Translate\Adapter;

use Phalcon\Translate\Adapter\NativeArray;

/**
 * Nest\Translate\Adapter\File
 *
 * @author Tomasz Ślązok <tomek@sabaki.pl>
 */
class File extends NativeArray
{
    public function __construct($file)
    {
        parent::__construct(['content' => include $file]);
    }
}
