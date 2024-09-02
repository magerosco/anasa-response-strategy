<?php

namespace Anasa\ResponseStrategy;

use Anasa\ResponseStrategy\OutputDataFormat\StrategyDataInterface;


interface ResponseContextInterface
{
    public function setStrategy(ResponseStrategyInterface $strategy);

    public function executeStrategy(StrategyDataInterface $data);
}
