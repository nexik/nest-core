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
    private $dictionary = [];

    public function __construct($config, $lang)
    {
        $defaultLang = $config->translate->default;
        $langs = $config->translate->langs->toArray();
        $messagesPath = $config->paths->app . '/messages/';

        if (false === in_array($lang, $langs)) {
            $lang = $defaultLang;
        }

        $path = sprintf('%s/%s.php', $messagesPath, $lang);

        if (file_exists($path)) {
            $this->dictionary = include $path;
        }

        if ($lang !== $defaultLang) {
            // path to default language dictionary
            $defaultPath =  sprintf('%s/%s.php', $messagesPath, $defaultLang);

            if (file_exists($defaultPath)) {
                $this->dictionary = array_merge(include $defaultPath, $this->dictionary);
            }
        }
    }

    public function query($index, $placeholders = [])
    {
        if ($this->exists($index)) {
            return $this->dictionary[$index];
        }

        return $index;
    }

    public function exists($index)
    {
        return isset($this->dictionary[$index]);
    }
}
