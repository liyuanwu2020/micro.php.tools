<?php

namespace Mszlu\Tools;

/**
 * @method string getModuleName() 获取当前所在模块的名称
 * @method \Yaf_View_Interface getView() 获取当前所在模块的名称
 * @method \Yaf_Request_Abstract getRequest() Retrieve current request object
 * @method \Yaf_Response_Abstract getResponse() Retrieve current response object
// * @method \Yaf_View_Interface getView() 获取当前的视图引擎
 * @method string render(string $tpl, array $parameters) 渲染视图模板
 * @method string getViewPath() 获取视图路径
 * @method void forward(string $module, string $controller, string $action, array $parameters) 将当前的请求转交给另外的Action
 * @method void redirect(string $url) 引发一个302重定向，重定向到另一个url
 *
 */
class YafSimpleController extends \Yaf_Controller_Abstract
{

    /**
     * 渲染一个视图并输出
     * @param string     $tpl
     * @param array|null $parameters
     * @return bool
     */
    public function display($tpl = '', array $parameters = null): bool
    {
        if (!strlen($tpl)) $tpl = $this->getRequest()->getActionName();

        return parent::display($tpl, $parameters);
    }

    /**
     * 为视图引擎分配一个模板变量
     * @param array|string      $name
     * @param array|string|null $value
     * @return void
     */
    public function assign(array|string $name, array|string $value = null): void
    {
        $loop = is_array($name) ? $name : [$name => $value];

        foreach ($loop as $k => $v) {
            $this->getView()->assign($k, $v);
        }
    }

    /**
     * @param $name
     * @param $default
     * @return array|mixed|null
     */
    public function getPut($name = null, $default = null): mixed
    {
        $_PUT = [];
        if ('put' == strtolower($_SERVER['REQUEST_METHOD'])) {
            parse_str(file_get_contents('php://input'), $_PUT);
        }
        return is_null($name) ? $_PUT : $_PUT[$name] ?? $default;
    }

    /**
     * @param $name
     * @param $default
     * @return array|mixed
     */
    public function getParams($name = null, $default = null): mixed
    {
        return is_null($name) ? $this->getRequest()->getParams() : $this->getRequest()->getParam($name, $default);
    }

    /**
     * @param $name
     * @param $default
     * @return mixed
     */
    public function getPost($name = null, $default = null)
    {
        return is_null($name) ? $this->getRequest()->getPost() : $this->getRequest()->getPost($name, $default);
    }

    /**
     * @param $name
     * @param $default
     * @return mixed
     */
    public function getQuery($name = null, $default = null): mixed
    {
        return is_null($name) ? $this->getRequest()->getQuery() : $this->getRequest()->getQuery($name, $default);
    }

    /**
     * @param $name
     * @param $default
     * @return mixed
     */
    public function getServer($name = null, $default = null): mixed
    {
        return is_null($name) ? $this->getRequest()->getServer() : $this->getRequest()->getServer($name, $default);
    }


}