<?php

namespace Anasa\ResponseStrategy\Output;

use Throwable;
use Anasa\ResponseStrategy\ResponseStrategyInterface;
use Anasa\ResponseStrategy\Facades\AdditionalDataRequest;
use Anasa\ResponseStrategy\OutputDataFormat\StrategyDataInterface;

class ViewResponseStrategy implements ResponseStrategyInterface
{
    public function getResponse(StrategyDataInterface $data = null)
    {
        try {
            $json_data = ['data' => $data !== null ? $data->getData()?->toJson() : null];

            return view(AdditionalDataRequest::getView(), ['data' => $json_data]);
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }
}
