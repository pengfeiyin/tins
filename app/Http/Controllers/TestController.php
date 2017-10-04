<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/9/30
 * Time: 上午9:48
 */

namespace App\Http\Controllers;



use App\Model\TestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends BaseController
{
    public function show(Request $request, $id)
    {
//        $item = app('db')->select('select * from platv4_user limit 1;');
//        var_dump($item);
        var_dump($id);
        $item = TestModel::find($id);
        var_dump($item);
//        $item = DB::select('select * from platv4_user limit 1;');
//        var_dump($item);
    }
}