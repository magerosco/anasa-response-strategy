<?php

namespace App\Services\ResponseStrategy;

use Exception;
use App\Services\ResponseStrategy\Output\ApiResponseStrategy;
use App\Services\ResponseStrategy\Output\ViewResponseStrategy;
use App\Services\ResponseStrategy\Output\RedirectResponseStrategy;

class ResponseStrategyFactory
{
    public static function createStrategy(string $method): ResponseStrategyInterface
    {
        switch ($method) {
            case 'API':
                return new ApiResponseStrategy();
            case 'index':
            case 'show':
            case 'create':
            case 'edit':
                return new ViewResponseStrategy();
            case 'store':
            case 'update':
            case 'destroy':
                return new RedirectResponseStrategy();
            default:
                throw new Exception('Unknown method');
        }
    }
}
