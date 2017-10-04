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

    public function withAliases($userAliases = [])
    {
        $defaults = [
            'Illuminate\Support\Facades\Auth' => 'Auth',
            'Illuminate\Support\Facades\Cache' => 'Cache',
            'Illuminate\Support\Facades\DB' => 'DB',
            'Illuminate\Support\Facades\Gate' => 'Gate',
            'Illuminate\Support\Facades\Log' => 'Log',
            'Illuminate\Support\Facades\Queue' => 'Queue',
            'Illuminate\Support\Facades\Route' => 'Route',
            'Illuminate\Support\Facades\Schema' => 'Schema',
            'Illuminate\Support\Facades\URL' => 'URL',
            'Illuminate\Support\Facades\Validator' => 'Validator',
        ];

        if (! static::$aliasesRegistered) {
            static::$aliasesRegistered = true;

            $merged = array_merge($defaults, $userAliases);

            foreach ($merged as $original => $alias) {
                class_alias($original, $alias);
            }
        }
    }

    protected function registerDatabaseBindings()
    {
        $this->singleton('db', function () {
            return $this->loadComponent(
                'database', [
                'App\Library\DatabaseServiceProvider',
                'Illuminate\Pagination\PaginationServiceProvider',
            ], 'db'
            );
        });
    }
}