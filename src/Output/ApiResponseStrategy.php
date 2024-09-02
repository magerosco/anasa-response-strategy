<?php

namespace Anasa\ResponseStrategy\Output;

use Throwable;
use Anasa\ResponseStrategy\ResponseStrategyInterface;
use Anasa\ResponseStrategy\OutputDataFormat\StrategyDataInterface;

class ApiResponseStrategy implements ResponseStrategyInterface
{
    public function getResponse(StrategyDataInterface $data = null)
    {
        try {
            $result = ['data' => $data !== null ? $data->getData() : null];

            if ($data !== null && !empty($data->getMessage())) {
                $result['message'] = $data->getMessage();
            }

            $statusCode = $data !== null ? $data->getHttpResponse() : 200;

            return response()->json($result, $statusCode);
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }
}
