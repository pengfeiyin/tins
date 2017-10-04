<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/9/28
 * Time: 下午11:08
 */


require_once __DIR__ . '/../vendor/autoload.php';
use App\Framework as Framework;
use App\Library\MysqlPool as MysqlPool;

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}


$http = new swoole_http_server('127.0.0.1', 9503);
$serverConfig = require __DIR__.'/../config/server.php';
$http->set($serverConfig);

$http->on('WorkerStart', function(swoole_http_server $server, int $workerId) {
    var_dump('swoole on worker start');
    $databaseConfig = require __DIR__.'/../config/database.php';
    $connections = $databaseConfig['connections'];
    MysqlPool::getInstance($connections)->initialPool();
});

$http->on('Start', function(swoole_http_server $server) {
    var_dump('swoole on server start');
});

$http->on('request', function(swoole_http_request $request, swoole_http_response $response) {
    var_dump('swoole on request');
    ob_start();
    $framework = new Framework($request);
    $framework->run();
    $content = ob_get_contents();
    ob_end_clean();
    $response->end($content);
    unset($framework);
});

$http->on('WorkerStop', function(swoole_http_server $server, int $workerId) {
    var_dump('swoole worker stop');
});


$http->start();

