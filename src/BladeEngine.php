<?php


namespace EasySwoole\Template\Smarty;

use Throwable;
use duncan3dc\Laravel\BladeInstance;

class BladeEngine
{
    private $engine;

    /**
     * Blade constructor.
     * @param string $view_path
     * @param string $cache_path
     */
    public function __construct(string $view_path, string $cache_path)
    {
        $this->engine = new BladeInstance($view_path, $cache_path);
    }

    /**
     * 模板渲染
     * @param string $template
     * @param array $data
     * @return string|null
     */
    public function render(string $template, array $data = []): ?string
    {
        return $this->engine->render($template, $data);
    }

    /**
     * 每次渲染完成都会执行清理
     * @param string|null $result
     * @param string $template
     * @param array $data
     * @param array $options
     */
    public function afterRender(?string $result, string $template, array $data = [], array $options = []): void
    {

    }

    /**
     * 异常处理
     * @param Throwable $throwable
     * @return string
     * @throws Throwable
     */
    public function onException(\Throwable $throwable): string
    {
        throw $throwable;
    }
}