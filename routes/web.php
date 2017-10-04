<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/9/30
 * Time: 上午9:33
 */
$router->get('/swer/test2/{id}', [
    'uses' => 'TestController@show'
]);