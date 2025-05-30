<?php

namespace App\Http\Integrations\Sms\Responses;

abstract class Response
{
    public string $code;

    public ?string $message;

    public function __construct(array $data)
    {
        $this->code = $data['code'] ?? 'error';
        $this->message = $data['message'] ?? null;
    }

    public function successful(): bool
    {
        return $this->code === 'ok';
    }

    public function toArray(): array
    {
        return ['code' => $this->code];
    }
}
