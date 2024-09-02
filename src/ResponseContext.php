<?php

namespace App\Services\ResponseStrategy;

use App\Services\ResponseStrategy\OutputDataFormat\StrategyDataInterface;

/**
 * Class ResponseContext
 * it's a context that will be used to execute the strategy
 *
 */
class ResponseContext implements ResponseContextInterface
{
    protected $strategy;

    public function __construct()
    {
        $this->strategy = null;
    }

    /**
     * Used by the middleware to set a concrete response strategy.
     */
    public function setStrategy(ResponseStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * It is used by the controller to execute the strategy as a concrete instance of the response.
     */
    public function executeStrategy(StrategyDataInterface $data = null): mixed
    {
        return $this->strategy->getResponse($data);
    }
}
