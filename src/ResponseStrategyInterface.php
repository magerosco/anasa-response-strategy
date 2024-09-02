<?php

namespace Anasa\ResponseStrategy;

use Anasa\ResponseStrategy\OutputDataFormat\StrategyDataInterface;

interface ResponseStrategyInterface
{
    public function getResponse(StrategyDataInterface $data);
}
