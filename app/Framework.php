<?php
/**
 * Created by PhpStorm.
 * User: yinpengfei
 * Date: 2017/9/29
 * Time: 下午11:14
 */

namespace App;


use Illuminate\Http\Request;

class Framework
{
    private $sRequest = null;
    public function __construct(\swoole_http_request $request)
    {
        $this->sRequest= $request;
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
        unset($this->sRequest);
    }

    private function getGET()
    {
        return isset($this->sRequest->get) ? $this->sRequest->get : [];
    }

    private function getPOST()
    {
        return isset($this->sRequest->post) ? $this->sRequest->post : [];
    }

    private function getRAW()
    {
        return $this->sRequest->rawContent();
    }

    private function getCOOKIE()
    {
        return isset($this->sRequest->cookie) ? $this->sRequest->cookie : [];
    }

    private function getSERVER()
    {
        $server = [];
        foreach ($this->sRequest->server as $key => $value) {
            $key = strtoupper($key);
            $server[$key] = $value;
        }
        return $server;
    }

    private function getHEADER()
    {
        return isset($this->sRequest->header) ? $this->sRequest->header : [];
    }

    private function getFILES()
    {
        return isset($this->sRequest->files) ? $this->sRequest->files : [];
    }

    public function run()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $request = new Request($this->getGET(),
            $this->getPOST(),
            [],
            $this->getCOOKIE(),
            $this->getFILES(),
            $this->getSERVER(),
            $this->getRAW());
        $app->run($request);
    }

}