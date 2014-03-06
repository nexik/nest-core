<?php
/**
 * This file is part Phalcon Nest (Phalcon SOLID bootstrap project for RAD)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 */
namespace Nest\Db\Adapter\Pdo;

/**
 * Nest\Db\Adapter\Mysql
 *
 *
 *
 * @author  Tomasz Ślązok <tomek@sabaki.pl>
 */
class Mysql extends \Phalcon\Db\Adapter\Pdo\Mysql
{
    /**
     * Constructor
     * @param Phalcon\Config $config
     */
    public function __construct($config)
    {
        parent::__construct($config->db->toArray());

        if ('utf8' === $config->db->charset) {
            $this->execute('SET NAMES UTF8');
        }
    }

    public function enableLogs($logger, $eventsManager)
    {
        //Listen all the database events
        $eventsManager->attach('db', function ($event, $connection) use ($logger) {
            if ($event->getType() == 'beforeQuery') {
                $sql = $connection->getSQLStatement();
                $variables = $connection->getSQLVariables();

                if (count($variables)) {
                    $sql = str_replace('?', "%s", $sql);
                    $params = array_merge([$sql], $variables);
                    $sql = call_user_func_array('sprintf', $params);
                }

                $logger->log($sql, Logger::INFO);
            }
        });

        //Assign the eventsManager to the db adapter instance
        $this->setEventsManager($eventsManager);
    }
}