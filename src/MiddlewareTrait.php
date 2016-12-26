<?php

namespace Fogio\Middleware;

trait MiddlewareTrait
{
    protected $_activities;
    protected $_activitiesWithMethod;

    public function setActivities(array $activities)
    {
        $this->_activitiesWithMethod = [];
        $this->_activities = $activities;

        return $this;
    }

    public function getActivities()
    {
        return $this->_activities;
    }

    public function getActivitiesWithMethod($method)
    {
        if (!isset($this->_activitiesWithMethod[$method])) {
            $this->_activitiesWithMethod[$method] = [];
            foreach ($this->_activities as $activity) {
                if (method_exists($method, $activity)) {
                    $this->_activitiesWithMethod[$method] = $activity;
                }
            }
        }
        return $this->_activitiesWithMethod[$method];
    }

    public function process($method, array $params = [])
    {
        return (new Process($this->getActivitiesWithMethod($method), $method, $params))->__invoke();
    }
}
