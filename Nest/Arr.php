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

/**
 * Nest\Arr
 *
 * @author     Tomasz Ślązok <tomek@landingi.com>
 * @author     Kohana Team
 * @copyright  (c) 2007-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Arr
{
    private static $delimeter = '.';

    /**
     * Gets a value from an array using a dot separated path.
     *
     *     // Get the value of $array['foo']['bar']
     *     $value = Arr::path($array, 'foo.bar');
     *
     * @param   array  $array     array to search
     * @param   string $path      key path string (delimiter separated) or array of keys
     * @param   mixed  $default   default value if the path is not set
     * @return  mixed
     */
    public static function path($array, $path, $default = null)
    {
        if (array_key_exists($path, $array)) {
            return $array[$path];
        }

        // Remove starting and ending delimiters and spaces
        $path = trim($path, ' ' . self::$delimeter);

        // Split the keys by delimiter
        $keys = explode(self::$delimeter, $path);

        do {
            $key = array_shift($keys);

            // Check if key is integer
            if (ctype_digit($key)) {
                $key = (int) $key;
            }

            if (isset($array[$key])) {
                if ($keys) {
                    // Dig down into the next part of the path if possible
                    if (is_array($array[$key])) {
                        $array = $array[$key];
                    } else {
                        return $default;
                    }
                } else {
                    return $array[$key];
                }
            } else {
                return $default;
            }
        } while ($keys);
    }
} 