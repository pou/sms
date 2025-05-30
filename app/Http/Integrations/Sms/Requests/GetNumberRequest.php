<?php

namespace App\Http\Integrations\Sms\Requests;

use App\Http\Integrations\Sms\SmsConnector;

class GetNumberRequest extends Request
{
    protected string $connector = SmsConnector::class;

    public function __construct(
        protected string $country,
        protected string $service,
        protected ?int $rentTime = null,
    ) {}

    public function params(): array
    {
        $params = [
            'action' => 'getNumber',
            'country' => $this->country,
            'service' => $this->service,
        ];

        if ($this->rentTime) {
            $params['rent_time'] = $this->rentTime;
        }

        return $params;
    }
}
