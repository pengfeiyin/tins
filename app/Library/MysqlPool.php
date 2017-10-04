<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/10/3
 * Time: 下午9:04
 */

namespace App\Library;


class MysqlPool
{

    private static $instance;
    private $pools = [];
    private $configs = [];
    /**
     * 数据库连接池初始化,加载方式 饿加载.
     * @param $configs array 数据库配置
     */
    public function __construct($configs = [])
    {
        foreach ($configs as $connection => $config) {
            $key = $this->getConnectionKey($config);
            $this->pools[$key] = new \SplQueue();
            $this->configs[$key] = $config;
        }
    }

    public static function getInstance($configs = [])
    {
        if (!self::$instance) {
            self::$instance = new MysqlPool($configs);
        }
        return self::$instance;
    }

    public function initialPool()
    {
        foreach ($this->configs as $key => $config) {
            $dsn = "mysql:host=".$config['host'].';dbname='.$config['database'];
            for ($i = 0; $i < $config['size']; $i++) {
                $pdo = new \PDO($dsn, $config['username'], $config['password']);
                $this->pools[$key]->enqueue($pdo);
            }
        }
    }

    public function getConnection(string $key)
    {
        $key = md5($key);
        $pdo = $this->pools[$key]->dequeue();
        $this->pools[$key]->enqueue($pdo);
        return $pdo;
    }

    private function getConnectionKey($config = [])
    {
        $driver = 'mysql';
        $host = $config['host'];
        $dbname = $config['database'];
        $username = $config['username'];
        $password = $config['password'];
        $key = "{$driver}:host={$host};dbname={$dbname};username={$username};password={$password}";
        return md5($key);
    }
}