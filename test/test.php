<?php

try {
    include_once '../vendor/autoload.php';

    $http = new \swoole_http_server('127.0.0.1', 9501);

    $config = new \EasySwoole\Template\Blade\Config();
    $config->setViewPath(__DIR__.'/views');
    $config->setCachePath(__DIR__.'/cache');
    $render = \EasySwoole\Template\Blade\Render::getInstance()->init($config,$http);
    $http->on('request', static function(\Swoole\Http\Request $request, \Swoole\Http\Response $response)use($render){
        $response->end($render->view('index/test', ['engine'=>'blade','test'=>'blade2']));
    });
    echo 'server start at http://127.0.0.1:9501'.PHP_EOL;
    $http->start();
}catch (\Throwable $e){
    var_dump($e->getMessage());
    var_dump($e->getLine());
}
