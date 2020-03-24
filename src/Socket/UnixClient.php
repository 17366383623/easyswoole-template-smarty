<?php


namespace EasySwoole\Template\Smarty\Socket;

use Swoole\Coroutine\Client;

class UnixClient
{
    private $client = null;

    /**
     * UnixClient constructor.
     * @param string $unixSock
     * @param array $socketConfig
     */
    public function __construct(string $unixSock, array $socketConfig = [])
    {
        $config  = [
            'open_length_check' => true,
            'package_length_type'   => 'N',
            'package_length_offset' => 0,
            'package_body_offset'   => 4,
            'package_max_length'    => 1024*1024
        ];
        $this->client = new Client(SWOOLE_UNIX_STREAM);
        $this->client->set(array_merge($config, $socketConfig));
        $this->client->connect($unixSock,null,3);
    }

    /**
     * destruct
     */
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        if($this->client->isConnected()){
            $this->client->close();
        }
    }

    /**
     * @param string $rawData
     * @return bool
     */
    public function send(string $rawData): ?bool
    {
        if($this->client->isConnected()){
            return $this->client->send($rawData);
        }else{
            return false;
        }
    }

    /**
     * get message
     *
     * @param float $timeout
     * @return string |null
     */
    public function recv(float $timeout = 0.1): ?string
    {
        if($this->client->isConnected()){
            $ret = $this->client->recv($timeout);
            if(!empty($ret)){
                return $ret;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }
}