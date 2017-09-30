<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/9/30
 * Time: 下午2:58
 */

namespace App\Library;

use Laravel\Lumen\Application as BaseApplication;

class Application extends BaseApplication
{
    protected function registerContainerAliases()
    {
        parent::registerContainerAliases();
        unset($this->aliases['Illuminate\Database\DatabaseManager']);
        unset($this->aliases['Illuminate\Database\ConnectionResolverInterface']);
        $this->aliases['App\Library\ConnectionResolverInterface'] = 'db';
        $this->aliases['App\Library\DatabaseManager'] = 'db';
    }
}