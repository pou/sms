<?php

namespace App\Console\Commands;

use App\Http\Integrations\Sms\Requests\CancelNumberRequest;
use App\Http\Integrations\Sms\Requests\GetNumberRequest;
use App\Http\Integrations\Sms\Requests\GetSmsRequest;
use App\Http\Integrations\Sms\Requests\GetStatusRequest;
use App\Http\Integrations\Sms\Responses\CancelNumberResponse;
use App\Http\Integrations\Sms\Responses\GetNumberResponse;
use App\Http\Integrations\Sms\Responses\GetSmsResponse;
use App\Http\Integrations\Sms\Responses\GetStatusResponse;
use Illuminate\Console\Command;

class SmsTestIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:test:integration
                            {--country=se}
                            {--service=ds}
                            {--rent_time=}';

    protected $description = 'Integration test';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Start API test...');

        $country = $this->option('country') ?? 'se';
        $service = $this->option('service') ?? 'ds';
        $rentTime = $this->option('rent_time');

        // 1. Get number
        $number = new GetNumberResponse(
            new GetNumberRequest(
                country: $country,
                service: $service,
                rentTime: $rentTime,
            )->send()
        );

        if (! $number->successful()) {
            $this->error("Error on receiving number: $number->message");

            return;
        }

        $this->info("Number: $number->number, for service $service in country $country");
        $this->info("Activation: $number->activation");

        // 2. check state
        $status = new GetStatusResponse(
            new GetStatusRequest($number->activation)->send()
        );

        if ($status->successful()) {
            $this->info("State: $status->status");
            $this->info("SMS Count: $status->count");
        } else {
            $this->error("Error on receiving state: $status->message");
        }

        // 3. get sms
        sleep(5);
        $tryCount = 0;
        $maxTries = 108;
        while ($tryCount < $maxTries) {
            $tryCount++;
            $this->info("Try $tryCount...");

            $sms = new GetSmsResponse(
                new GetSmsRequest($number->activation)->send()
            );

            if ($sms->successful()) {
                $this->info("SMS received: $sms->sms");
                break;
            }

            $this->warn("No SMS yet: $sms->message");
            sleep(10);
        }

        // 4. cancel nubmer
        $cancel = new CancelNumberResponse(
            new CancelNumberRequest($number->activation)->send()
        );

        if ($cancel->successful()) {
            $this->info('Number canceled successfully.');
        } else {
            $this->error("Can't cancel the number: $cancel->message");
        }
    }
}
