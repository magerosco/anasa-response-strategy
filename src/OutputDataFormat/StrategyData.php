<?php

namespace App\Services\ResponseStrategy\OutputDataFormat;


class StrategyData implements StrategyDataInterface
{
    private array|object $data = [];
    private string $message = '';
    private int $response = 200;

    public function setStrategyData(array|object $data = [], string $message = '', int $response = 200): StrategyDataInterface
    {
        $this->data = $data;
        $this->message = $message;
        $this->response = $response;

        return $this;
    }

    public function getData(): array|object
    {
        return $this->data;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getHttpResponse(): int
    {
        return $this->response;
    }
}
