<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/9/30
 * Time: 下午2:35
 */

namespace App\Library;

use Illuminate\Database\DatabaseManager as BaseDatabaseManager;
use Illuminate\Support\Facades\Log;

class DatabaseManager extends BaseDatabaseManager
{
    public function __construct($app, ConnectionFactory $factory)
    {
        parent::__construct($app, $factory);
    }
}