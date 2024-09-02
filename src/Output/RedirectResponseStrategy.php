<?php

namespace Anasa\ResponseStrategy\Output;

use Throwable;
use Anasa\ResponseStrategy\ResponseStrategyInterface;
use Anasa\ResponseStrategy\AdditionalDataRequest;
use Anasa\ResponseStrategy\OutputDataFormat\StrategyDataInterface;

class RedirectResponseStrategy implements ResponseStrategyInterface
{
    public function getResponse(StrategyDataInterface $data = null)
    {
        try {            
            $service = AdditionalDataRequest::getInstance();

            $json_data = ['data' => $data !== null ? $data->getData()?->toJson() : null];

            if ($data !== null && !empty($data->getMessage())) {
                $result['message'] = $data->getMessage();
            }

            $statusCode = $data !== null ? $data->getHttpResponse() : 200;

            return redirect()->route($service->getRoute())->with($json_data, $statusCode);
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }
}
