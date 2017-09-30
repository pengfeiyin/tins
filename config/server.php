<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/9/29
 * Time: 下午11:23
 */
return [
    'worker_num'    => 2,
    'backlog'       => 128,
    'max_request'   => 10000,
    'dispatch_mode' => 3,
    'daemonize'     =>  true,
    'log_file'      =>  __DIR__ . '/../../logs/swer-' . date("Y-m-d") . '.log'
];