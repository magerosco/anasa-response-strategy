<?php

namespace Anasa\ResponseStrategy\Output;

use Throwable;
use Anasa\ResponseStrategy\ResponseStrategyInterface;
use Anasa\ResponseStrategy\AdditionalDataRequest;
use Anasa\ResponseStrategy\OutputDataFormat\StrategyDataInterface;

class ViewResponseStrategy implements ResponseStrategyInterface
{
    public function getResponse(StrategyDataInterface $data = null)
    {
        try {
            $service = AdditionalDataRequest::getInstance();

            $json_data = ['data' => $data !== null ? $data->getData()?->toJson() : null];

            return view($service->getView(), ['data' => $json_data]);
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }
}
