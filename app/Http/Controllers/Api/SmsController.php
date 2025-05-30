<?php

namespace App\Http\Controllers\Api;

use App\Http\Integrations\Sms\Requests\CancelNumberRequest;
use App\Http\Integrations\Sms\Requests\GetNumberRequest;
use App\Http\Integrations\Sms\Requests\GetSmsRequest;
use App\Http\Integrations\Sms\Requests\GetStatusRequest;
use App\Http\Integrations\Sms\Responses\CancelNumberResponse;
use App\Http\Integrations\Sms\Responses\GetNumberResponse;
use App\Http\Integrations\Sms\Responses\GetSmsResponse;
use App\Http\Integrations\Sms\Responses\GetStatusResponse;
use App\Http\Requests\SmsRequest;
use Illuminate\Http\JsonResponse;

class SmsController
{
    public function getNumber(SmsRequest $request): JsonResponse
    {
        $response = new GetNumberResponse(
            new GetNumberRequest(
                country: $request->input('country'),
                service: $request->input('service'),
                rentTime: $request->input('rent_time')
            )->send()
        );

        return response()->json($response->toArray(), $response->successful() ? 200 : 400);
    }

    public function getSms(SmsRequest $request): JsonResponse
    {
        $response = new GetSmsResponse(
            (new GetSmsRequest(
                activation: $request->input('activation')
            ))->send()
        );

        return response()->json($response->toArray(), $response->successful() ? 200 : 400);
    }

    public function cancelNumber(SmsRequest $request): JsonResponse
    {
        $response = new CancelNumberResponse(
            (new CancelNumberRequest(
                activation: $request->input('activation')
            ))->send()
        );

        return response()->json($response->toArray(), $response->successful() ? 200 : 400);
    }

    public function getStatus(SmsRequest $request): JsonResponse
    {
        $response = new GetStatusResponse(
            (new GetStatusRequest(
                activation: $request->input('activation')
            ))->send()
        );

        return response()->json($response->toArray(), $response->successful() ? 200 : 400);
    }
}
