<?php

namespace Anasa\ResponseStrategy\Facades;


use Illuminate\Support\Facades\Facade;

class AdditionalDataRequest extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'additionalDataRequest';
    }
}
