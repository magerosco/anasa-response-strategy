<?php

namespace Anasa\ResponseStrategy\OutputDataFormat;

interface StrategyDataInterface
{
    public function setStrategyData();
    public function getData(): array|object;
    public function getMessage(): string;
    public function getHttpResponse(): int;
}
