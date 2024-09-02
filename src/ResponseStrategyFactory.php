<?php

namespace Anasa\ResponseStrategy;

use Exception;
use Anasa\ResponseStrategy\Output\ApiResponseStrategy;
use Anasa\ResponseStrategy\Output\ViewResponseStrategy;
use Anasa\ResponseStrategy\Output\RedirectResponseStrategy;

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
