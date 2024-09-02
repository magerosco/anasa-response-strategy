<?php

namespace App\Services\ResponseStrategy;

class AdditionalDataRequest
{
    protected $method;
    protected $view;
    protected $route;

    /**
     * Set the value of route
     */
    public function setRoute($route): self
    {
        $this->route = $route;

        return $this;
    }
    /**
     * Set the value of route
     */
    public function setView($view): self
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Set the value of method
     */
    public function setMethod($method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get the value of method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the value of view
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Get the value of route
     */
    public function getRoute()
    {
        return $this->route;
    }
}
