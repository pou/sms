<?php

namespace App\Http\Integrations\Sms;

use App\Http\Integrations\Sms\Requests\Request;
use Illuminate\Support\Facades\Http;

class SmsConnector extends Connector
{
    public function send(Request $request): array
    {
        $params = $request->params();

        $params['token'] = config('services.sms.token');

        $data = Http::get(
            config('services.sms.base_url'),
            $params
        );

        return $data->json();
    }
}
