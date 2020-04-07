<?php

namespace EasySwoole\Template\Smarty;


class Config
{
    /** @var \Smarty renderEngine */
    private $engine;

    /** @var int timeout */
    private $timeout = 0.5;

    /** @var int workNum */
    private $workerNum = 3;

    /** @var string renderProcessNamePrefix */
    private $socketPrefix = 'render';

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->setEngine(new \Smarty());
    }

    /**
     * get view path
     *
     * @return \Smarty
     */
    public function getEngine(): \Smarty
    {
        return $this->engine;
    }


    /**
     * get timeout
     *
     * @return float
     */
    public function getTimeout(): float
    {
        return (float)$this->timeout;
    }

    /**
     * get render worker process number
     *
     * @return int
     */
    public function getWorkerNum(): int
    {
        return $this->workerNum;
    }

    /**
     * get the process name prefix of render
     *
     * @return string
     */
    public function getSocketPrefix(): string
    {
        return $this->socketPrefix;
    }

    /**
     * set Engine
     *
     * @param \Smarty $engine
     */
    public function setEngine(\Smarty $engine): void
    {
        $this->engine = $engine;
    }


    /**
     * set timeout
     *
     * @param float $timeout
     */
    public function setTimeout(float $timeout): void
    {
        $this->timeout = $timeout;
    }

    /**
     * set worker number
     *
     * @param int $num
     */
    public function setWorkerNum(int $num): void
    {
        $this->workerNum = $num;
    }

    /**
     * set the process's prefix of render
     *
     * @param string $prefix
     */
    public function setSocketPrefix(string $prefix): void
    {
        $this->socketPrefix = $prefix;
    }
}