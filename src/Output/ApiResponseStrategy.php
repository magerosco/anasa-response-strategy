<?php

namespace App\Services\ResponseStrategy\Output;

use Throwable;
use App\Services\ResponseStrategy\ResponseStrategyInterface;
use App\Services\ResponseStrategy\OutputDataFormat\StrategyDataInterface;

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
