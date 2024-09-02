<?php

namespace App\Services\ResponseStrategy;

use App\Services\ResponseStrategy\OutputDataFormat\StrategyDataInterface;

interface ResponseStrategyInterface
{
    public function getResponse(StrategyDataInterface $data);
}
