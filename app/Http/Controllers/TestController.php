<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/9/30
 * Time: 上午9:48
 */

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class TestController extends BaseController
{
    public function show(Request $request, $name)
    {
        var_dump($name);
//        var_dump($request);
    }
}