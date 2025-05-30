<?php

namespace App\Http\Integrations\Sms\Responses;

class GetNumberResponse extends Response
{
    public string $number;

    public string $activation;

    public ?float $cost;

    public ?string $endDate = null;

    public function __construct(array $data)
    {
        parent::__construct($data);

        if ($this->successful()) {
            $this->number = $data['number'] ?? null;
            $this->activation = $data['activation'] ?? null;
            $this->endDate = $data['end_date'] ?? null;
            $this->cost = isset($data['cost']) ? (float) $data['cost'] : null;
        }
    }

    public function toArray(): array
    {
        $data = [
            'number' => $this->number,
            'activation' => $this->activation,
        ];

        if ($this->cost) {
            $data['cost'] = $this->cost;
        }

        if ($this->endDate) {
            $data['end_date'] = $this->endDate;
        }

        return array_merge(parent::toArray(), $data);
    }
}
