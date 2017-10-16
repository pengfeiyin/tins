<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/10/4
 * Time: 下午2:13
 */

namespace App\Library;

use Illuminate\Database\Connectors\Connector as BaseConnector;

class Connector extends BaseConnector
{
    protected function createPdoConnection($dsn, $username, $password, $options)
    {
        $key = $dsn.';username='.$username.';password='.$password;
        $pdo = MysqlPool::getInstance()->getConnection($key);
        return $pdo;
    }

    protected function tryAgainIfCausedByLostConnection(\Exception $e, $dsn, $username, $password, $options)
    {
        throw $e;
    }
}