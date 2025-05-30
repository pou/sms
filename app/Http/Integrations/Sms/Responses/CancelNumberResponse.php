<?php

namespace App\Http\Integrations\Sms\Responses;

class CancelNumberResponse extends Response
{
    public string $activation;

    public string $status;

    public function __construct(array $data)
    {
        parent::__construct($data);

        if ($this->successful()) {
            $this->activation = $data['activation'] ?? null;
            $this->status = $data['status'] ?? null;
        }
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'activation' => $this->activation,
            'status' => $this->status,
        ]);
    }
}
