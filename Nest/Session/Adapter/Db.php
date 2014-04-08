<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Session\Adapter;

/**
 * Nest\Session\Adapter\Database
 *
 * Easily injectable version of Phalcon\Session\Adapter\Database
 *
 * @deprecated
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class Db extends \Phalcon\Session\Adapter\Database
{
    /**
     * Constructor
     *
     * @param \Phalcon\Db\Adapter $db
     * @param \Phalcon\Config     $config
     * @throws \Phalcon\Session\Exception
     */
    public function __construct($db, $config)
    {
        session_name($config->session->cookie);
        session_set_cookie_params(
            $config->session->timeout,
            '/',
            $config->session->domain,
            $config->session->secure
        );

        parent::__construct([
            'db' => $db,
            'table' => $config->session->adpater->table
        ]);

        $this->start();
    }
}