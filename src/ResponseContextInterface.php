<?php

namespace App\Services\ResponseStrategy;

use App\Services\ResponseStrategy\OutputDataFormat\StrategyDataInterface;


interface ResponseContextInterface
{
    public function setStrategy(ResponseStrategyInterface $strategy);

    public function executeStrategy(StrategyDataInterface $data);
}
