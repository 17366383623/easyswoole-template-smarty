# EasySwoole-Template-Smarty

## 扩展安装
```bash
composer require yehua/easyswoole-smarty
```

## 实现原理
注册N个自定义进程做渲染进程，进程内关闭协程环境，并监听UNIXSOCK，客户端调用携程的client客户端发送数据给进程渲染，进程再返回结果给客户端，用来解决PHP模板引擎协程安全问题。

## 测试用例使用教程

```php
<?php
include_once '../vendor/autoload.php';

$http = new \swoole_http_server('127.0.0.1', 9501);
// 设置全局渲染参数
$smarty = new \Smarty();
$smarty->setTemplateDir('./views');
$smarty->setCacheDir('./cache');
$smarty->caching = TRUE;
$config = new \EasySwoole\Template\Smarty\Config();
$render = \EasySwoole\Template\Smarty\Render::getInstance()->init($smarty,$config,$http);
$http->on('request', static function(\Swoole\Http\Request $request, \Swoole\Http\Response $response)use($render){
    // 设置本次渲染参数
    $smarty = new \Smarty();
    $smarty->left_delimiter = '<{';
    $smarty->right_delimiter = '}>';
    $smarty->setTemplateDir('./views');
    $smarty->setCacheDir('./cache');
    $response->end($render->view('index/test.tpl', ['engine'=>'smarty','test'=>'smarty2'], $smarty));
});
echo 'server start at http://127.0.0.1:9501'.PHP_EOL;
$http->start();
```

### 启动测试服务器

代码包内置了一个小型的测试服务器，只需要运行目录下的test.php即可开启测试
```bash
php test.php
```

## EasySwoole框架使用教程

```php
// 框架 EasySwooleEvent.php 中 mianServerCreate 方法中加入以下配置
public static function mainServerCreate(EventRegister $register)
{
    // 设置全局渲染参数
    $smarty = new \Smarty();
    $smarty->setTemplateDir(EASYSWOOLE_ROOT.'/Template/');
    $smarty->setCacheDir(EASYSWOOLE_ROOT.'/Template/Cache/');
    $smarty->caching = TRUE;
    $config = new \EasySwoole\Template\Smarty\Config();
    \EasySwoole\Template\Smarty\Render::getInstance()->init($smarty,$config);
}

// 控制器中使用
public function index()
{
    // 可添加参数三 用于设置当次渲染配置并且只作用于当次（默认为空）
    $renderStr = \EasySwoole\Template\Smarty\Render::getInstance()->view('Index/index',['time'=>time()]);
    $this->response()->write($renderStr);
}

// 设置当次渲染参数配置
public function index()
{
    // 设置本次渲染参数
    $smarty = new \Smarty();
    $smarty->left_delimiter = '<{';
    $smarty->right_delimiter = '}>';
    // 可添加参数三 用于设置当次渲染配置并且只作用于当次（默认为空）
    $renderStr = \EasySwoole\Template\Smarty\Render::getInstance()->view('Index/index',['time'=>time()],$smarty);
    $this->response()->write($renderStr);
}

ps: Smarty更多的配置参数见：https://www.php.cn/manual/view/15656.html
```