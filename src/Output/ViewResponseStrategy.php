<?php

namespace App\Services\ResponseStrategy\Output;

use Throwable;
use App\Services\ResponseStrategy\ResponseStrategyInterface;
use App\Services\ResponseStrategy\Facades\AdditionalDataRequest;
use App\Services\ResponseStrategy\OutputDataFormat\StrategyDataInterface;

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
