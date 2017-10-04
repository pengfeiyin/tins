<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/9/29
 * Time: 下午11:06
 */

require_once __DIR__ . '/../vendor/autoload.php';

//try {
//    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
//} catch (Dotenv\Exception\InvalidPathException $e) {
//    //
//}


$app = new App\Library\Application(realpath(__DIR__.'/../'));

$app->withFacades();
$app->withEloquent();

//$app->singleton(
//    Illuminate\Contracts\Debug\ExceptionHandler::class,
//    App\Exceptions\Handler::class
//);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

//$app->configure('database');

return $app;
