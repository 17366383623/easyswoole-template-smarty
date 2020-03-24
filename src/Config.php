<?php

namespace EasySwoole\Template\Smarty;


class Config
{
    /** @var string path */
    private $view_path;

    /** @var string path */
    private $cache_path;

    /** @var int timeout */
    private $timeout = 0.5;

    /** @var int workNum */
    private $workerNum = 3;

    /** @var string renderProcessNamePrefix */
    private $socketPrefix = 'render';


    /**
     * get view path
     *
     * @return string
     */
    public function getViewPath(): string
    {
        return $this->view_path;
    }

    /**
     * get cache path
     *
     * @return string |null
     */
    public function getCachePath(): ?string
    {
        return $this->cache_path;
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
     * set view path
     *
     * @param string $path
     */
    public function setViewPath(string $path): void
    {
        if(substr($path, -1, 1) !== '/'){
            $this->view_path = $path.'/';
            return;
        }
        $this->view_path = $path;
    }

    /**
     * set cache path
     *
     * @param string $path
     */
    public function setCachePath(string $path): void
    {
        if(substr($path, -1, 1) !== '/'){
            $this->cache_path = $path.'/';
            return;
        }
        $this->cache_path = $path;
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