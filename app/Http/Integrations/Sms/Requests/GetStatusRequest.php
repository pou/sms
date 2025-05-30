<?php

namespace App\Http\Integrations\Sms\Requests;

use App\Http\Integrations\Sms\SmsConnector;

class GetStatusRequest extends Request
{
    protected string $connector = SmsConnector::class;

    public function __construct(
        protected string $activation,
    ) {}

    public function params(): array
    {
        return [
            'action' => 'getStatus',
            'activation' => $this->activation,
        ];
    }
}
