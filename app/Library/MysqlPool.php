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
                try {
                    $pdo = new \PDO($dsn, $config['username'], $config['password']);
                    $this->pools[$key]->enqueue($pdo);
                } catch (\PDOException $e) {
                    print_r('initialPool exception : ' . $e->getMessage() . PHP_EOL);
                    throw $e;
                }
            }
        }

        $this->listenLinks();
    }

    public function listenLinks()
    {
        swoole_timer_tick(6000, function() {
            foreach ($this->pools as $key=>$pool) {
                $config = $this->configs[$key];
                $poolCount = $pool->count();
                $count = $poolCount > $config['size'] ? $poolCount : $config['size'];
                for ($i = 0; $i < $count; $i++) {
                    $pdo = $this->pools[$key]->dequeue();
                    try {
                        $pdo->getAttribute(\PDO::ATTR_SERVER_INFO);
                        $this->pools[$key]->enqueue($pdo);
                    } catch (\PDOException $e) {
                        $this->addConnection($key);
                    }
                }
            }
        });
    }

    protected function addConnection($key)
    {
        var_dump('addConnection'.PHP_EOL);
        $config = $this->configs[$key];
        $dsn = "mysql:host=".$config['host'].';dbname='.$config['database'];
        try {
            $pdo = new \PDO($dsn, $config['username'], $config['password']);
            $this->pools[$key]->enqueue($pdo);
        } catch (\PDOException $e) {
            print_r('addConnection exception : ' . $e->getMessage() . PHP_EOL);
            throw $e;
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