<?php
/**
* This file is part of Landingi system (https://landingi.com)
*
* @link       https://landingi.com/
* @copyright  Landingi Sp. z o.o.
*/

namespace Nest\Cache;

/**
 * Nest\Cache\InternalFile
 *
 * Description
 *
 * @author Tomasz Ślązok <tomek@landingi.com>
 */
class InternalFile 
{
    /**
     * @var string
     */
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $file = $this->getCachedPath($key);

        if (file_exists($file)) {
            return unserialize(file_get_contents($file));
        }
    }

    /**
     * @param       $key
     * @param mixed $data
     */
    public function set($key, $data)
    {
        $file = $this->getCachedPath($key);

        file_put_contents($file, serialize($data));
        chmod($file, 0777);
    }

    /**
     * Calculate cached path to internal filesystem cache
     * base on key name
     *
     * @param $key
     * @return string
     */
    private function getCachedPath($key)
    {
        return $this->path . '/' . md5($key);
    }

} 