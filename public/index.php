<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/9/28
 * Time: 下午11:08
 */

use App\Framework as Framework;
require_once __DIR__ . '/../vendor/autoload.php';
$http = new swoole_http_server('127.0.0.1', 9503);
$serverConfig = require __DIR__.'/../config/server.php';
$http->set($serverConfig);

$http->on('request', function(swoole_http_request $request, swoole_http_response $response) {
    ob_start();
    $framework = new Framework($request);
    $framework->run();
    $content = ob_get_contents();
    ob_end_clean();
    $response->end($content);
    unset($framework);
});

$http->start();

