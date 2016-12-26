<?php

namespace Fogio\Middleware;

class Process
{
    protected $_queue;
    protected $_method;

    public function __construct(array $activities, $method = '__invoke', array $params = [])
    {
        $this->_queue = $activities;
        $this->_method = $method;
        foreach ($params as $k => $v) {
            $this->$k = $v;
        }
    }

    public function __invoke()
    {
        $activity = array_shift($this->_queue);
        if ($activity) {
            call_user_func([$activity, $this->_method], $this);
        }

        return $this;
    }

    public function getMethod()
    {
        return $this->_method;
    }

    public function prepend(array $activities)
    {
        $this->_queue = array_merge($activities, $this->_queue);

        return $this;
    }

    public function append(array $tasks)
    {
        $this->_queue = array_merge($this->_queue, $tasks);

        return $this;
    }

}
