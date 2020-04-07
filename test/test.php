<?php

include_once '../vendor/autoload.php';

$http = new \swoole_http_server('127.0.0.1', 9501);

$smarty = new \Smarty();
$smarty->setTemplateDir('./views');
$smarty->setCacheDir('./cache');
$smarty->caching = TRUE;
$config = new \EasySwoole\Template\Smarty\Config();
$config->setEngine($smarty);
$render = \EasySwoole\Template\Smarty\Render::getInstance()->init($config,$http);
$http->on('request', static function(\Swoole\Http\Request $request, \Swoole\Http\Response $response)use($render){
    $smarty = new \Smarty();
    $smarty->setTemplateDir('./views');
    $smarty->setCacheDir('./cache');
    $smarty->setLeftDelimiter('<{');
    $smarty->setRightDelimiter('}>');
    $response->end($render->view('index/test.tpl', ['engine'=>'smarty','test'=>'smarty2'], $smarty));
});
echo 'server start at http://127.0.0.1:9501'.PHP_EOL;
$http->start();
