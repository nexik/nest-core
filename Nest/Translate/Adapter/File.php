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

class File implements \Phalcon\Translate\AdapterInterface
{
    /**
     * @var Phalcon\Config
     */
    private $config;

    /**
     * @var array
     */
    private $dictionary = [];

    public function __construct($config, $lang)
    {
        $this->config = $config;
        $this->loadDictionary($lang);

        if ($lang !== $config->i18n->default) {
            $this->loadDictionary($config->i18n->default);
        }
    }

    /**
     * Return translations for given key
     *
     * @param  string $index
     * @param  array $placeholders
     * @return string
     */
    public function query($index, $placeholders = [])
    {
        if ($this->exists($index)) {
            return $this->dictionary[$index];
        }

        return $index;
    }

    /**
     * Check if translations for given key exists
     *
     * @param  string $index
     * @return boolean
     */
    public function exists($index)
    {
        return isset($this->dictionary[$index]);
    }

    private function loadDictionary($lang)
    {
        $path = sprintf("%s/messages/%s.php", $this->config->paths->app, $lang);

        if (file_exists($path)) {
            $this->dictionary = array_merge($this->dictionary, include $path);
        }
    }
}
