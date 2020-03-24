<?php

namespace EasySwoole\Template\Smarty;

use EasySwoole\Component\Process\Exception;
use EasySwoole\Component\Singleton;
use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\Template\Smarty\Socket\Protocol;
use EasySwoole\Template\Smarty\Socket\UnixClient;
use EasySwoole\Template\Smarty\Process\RenderProcess;
use EasySwoole\Template\Smarty\Process\RenderProcessConfig;

class Render
{
    use Singleton;

    /**
     * @var Config
     */
    private $config;


    /**
     * @var render $worker
     */
    private $worker;

    /**
     * init render dev
     * @param Config $config
     * @param \swoole_server $server
     * @return Render
     * @throws Component\Process\Exception
     * @throws Exception
     */
    public function init(Config $config, \swoole_server $server = NULL): Render
    {
        $this->setConfig($config);
        $server = $server?:ServerManager::getInstance();
        $this->attachRenderServer($server);
        return $this;
    }

    /**
     * set render engine config
     *
     * @param Config $config
     */
    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }


    /**
     * render task
     *
     * @param string $path
     * @param array $data
     * @return mixed
     */
    public function view(string $path, array $data = []): ?string
    {
        $sockFileFd = $this->getRenderProcess();
        $client = new UnixClient($sockFileFd);
        $client->send(Protocol::pack(serialize(([
            'template' => $path,
            'data' => $data,
            'options' => $this->config
        ]))));
        $recvData = $client->recv($this->config->getTimeout());
        if($recvData){
            return unserialize(Protocol::unpack($recvData));
        }
        return NULL;
    }

    /**
     * create render process
     *
     * @param \swoole_server $server
     * @throws Component\Process\Exception
     * @throws Exception
     */
    public function attachRenderServer(\swoole_server $server): void
    {
        $processList = $this->generateProcessList();
        foreach ($processList as $pro){
            $server->addProcess($pro->getProcess());
        }
    }

    /**
     * create render process
     *
     * @return array
     * @throws Component\Process\Exception
     * @throws Exception
     */
    protected function generateProcessList():array
    {
        $array = [];
        for ($i = 1;$i <= $this->config->getWorkerNum();$i++){
            $config = new RenderProcessConfig();
            $config->setProcessName("Render.{$this->config->getSocketPrefix()}Worker.{$i}");
            $config->setSocketFile(__DIR__."/Render.{$this->config->getSocketPrefix()}Worker.{$i}.sock");
            $config->setAsyncCallback(false);
            $array[$i] = new RenderProcess($config);
            $this->worker[$i] = $array[$i];
        }
        return $array;
    }

    /**
     * get unix socket resource fd
     *
     * @return string
     */
    private function getRenderProcess(): string
    {
        mt_srand();
        $id = rand(1,$this->config->getWorkerNum());
        return __DIR__."/Render.{$this->config->getSocketPrefix()}Worker.{$id}.sock";
    }
}