<?php

namespace Anasa\ResponseStrategy;

class AdditionalDataRequest
{
    private static $instance;

    protected $method;
    protected $view;
    protected $route;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

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
