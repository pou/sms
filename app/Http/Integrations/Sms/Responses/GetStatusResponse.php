<?php

namespace App\Http\Integrations\Sms\Responses;

class GetStatusResponse extends Response
{
    public ?string $status = null;

    public ?int $count = null;

    public ?string $endRentDate = null;

    public function __construct(array $data)
    {
        parent::__construct($data);

        if ($this->successful()) {
            $this->status = $data['status'] ?? null;
            $this->count = isset($data['count_sms']) ? (int) $data['count_sms'] : null;
            $this->endRentDate = $data['end_rent_date'] ?? null;
        }
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'status' => $this->status,
            'count_sms' => $this->count,
            'end_rent_date' => $this->endRentDate,
        ]);
    }
}
