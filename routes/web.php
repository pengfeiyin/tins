<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/9/30
 * Time: 上午9:33
 */
$router->put('/swer/test2/{name}', [
    'uses' => 'TestController@show'
]);