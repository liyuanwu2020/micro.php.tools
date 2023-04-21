<?php

namespace Mszlu\Tools;

class Middleware
{
    protected $middlewares = [];
    protected $context;

    public function __construct()
    {
        $this->context = [];
    }

    public function addMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function run()
    {
        $index = 0;
        $next = function ($context) use (&$index, &$next) {
            if (isset($this->middlewares[$index])) {
                $middleware = $this->middlewares[$index];
                $index++;
                $middleware($context, $next);
            }
        };

        $next($this->context);
    }
}

$middleware = new Middleware();

$middleware->addMiddleware(function ($context, $next) {
    $context['foo'] = 'bar';
    $next($context);
});

$middleware->addMiddleware(function ($context, $next) {
    echo $context['foo'];  // bar
    $context['hello'] = 'world';
    $next($context);
});

$middleware->addMiddleware(function ($context, $next) {
    var_dump($context);  // bar
    $next();
});

$middleware->run();
