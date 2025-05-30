<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmsRequest extends FormRequest
{
    public function authorize(): bool
    {
        // todo
        return true;
    }

    public function rules(): array
    {
        return match ($this->route()->getActionMethod()) {
            'getNumber' => [
                'country' => 'required|string|size:2',
                'service' => 'required|string|size:2',
                'rent_time' => 'nullable|integer|min:1|max:24',
            ],
            'getSms', 'cancelNumber', 'getStatus' => [
                'activation' => 'required|numeric',
            ],
            default => [],
        };
    }
}
