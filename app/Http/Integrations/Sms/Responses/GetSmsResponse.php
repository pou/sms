<?php

namespace App\Http\Integrations\Sms\Responses;

class GetSmsResponse extends Response
{
    public string $sms;

    public function __construct(array $data)
    {
        parent::__construct($data);

        if ($this->successful()) {
            $this->sms = $data['sms'] ?? null;
        }
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'sms' => $this->sms,
        ]);
    }
}
