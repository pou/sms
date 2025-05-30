<?php

namespace App\Http\Integrations\Sms;

use App\Http\Integrations\Sms\Requests\Request;

abstract class Connector
{
    abstract public function send(Request $request): array;
}
