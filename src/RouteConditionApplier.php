<?php

namespace Imanghafoori\HeyMan;

class RouteConditionApplier
{
    private $target;

    private $value;

    private $routeNames = [];

    private $actions = [];

    private $urls = [];

    /**
     * RouteConditionApplier constructor.
     *
     * @param $target
     * @param $value
     */
    public function init($target, $value)
    {
        $this->target = $target;
        $this->value = $value;
        return $this;
    }

    public function getUrls($url)
    {
        return $this->urls[$url] ?? function(){};
    }

    public function getRouteNames($routeName)
    {
        return $this->routeNames[$routeName] ?? function(){};
    }

    public function getActions($action)
    {
        return $this->actions[$action] ?? function(){};
    }

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
    {
        foreach ($this->value as $value) {
            $this->{$this->target}[$value] = $callback;
        }
    }
}