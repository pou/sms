<?php

namespace App\Http\Integrations\Sms\Requests;

use App\Http\Integrations\Sms\Connector;

abstract class Request
{
    protected string $connector;

    abstract public function params(): array;

    public function send(): array
    {
        return $this->resolveConnector()->send($this);
    }

    protected function resolveConnector(): Connector
    {
        return new $this->connector;
    }
}
