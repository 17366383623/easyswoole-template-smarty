<?php
namespace EasySwoole\Template\Smarty\Process;

use EasySwoole\Component\Process\Socket\AbstractUnixProcess;
use EasySwoole\Template\Smarty\BladeEngine;
use EasySwoole\Template\Smarty\Socket\Protocol;
use Swoole\Coroutine\Socket;


class RenderProcess extends AbstractUnixProcess
{
    public function onAccept(Socket $socket): void
    {
        try {
            $data = $this->getUnixMessage($socket);
            $render = $this->getRender($data);
            if($data){
                $reply = $this->renderView($render, $data);
                $socket->sendAll(Protocol::pack(serialize($reply)));
            }
        }catch (\Throwable $throwable){
            $this->onException($throwable);
        } finally {
            $socket->close();
        }
    }

    protected function getRender(array $options): \Smarty
    {
        $config = $options['options'];
        return $config->getEngine();
    }

    protected function getUnixMessage(Socket $socket): ?array
    {
        $header = $socket->recvAll(4,1);
        if(strlen($header) !== 4){
            $socket->close();
            return NULL;
        }
        $allLength = Protocol::packDataLength($header);
        $data = $socket->recvAll($allLength,1);
        if(strlen($data) === (int)$allLength){
            return unserialize($data);
        }else{
            $socket->close();
            return NULL;
        }
    }

    protected function renderView(\Smarty $engine, array $params): ?string
    {
        ob_start();
        $reply = $engine->display($params['template'],$params['data']);
        return ob_get_clean();
    }

    protected function onException(\Throwable $throwable,...$arg): void
    {
        trigger_error("{$throwable->getMessage()} at file:{$throwable->getFile()} line:{$throwable->getLine()}");
    }

    protected function onPipeReadable(Process $process): void
    {
        $msg = $process->read();
        if($msg == 'shutdown'){
            $process->exit(0);
        }
    }
}