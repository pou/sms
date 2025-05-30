<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SmsTestHttp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:test:http
                            {--host=http://127.0.0.1:8000}
                            {--country=se}
                            {--service=ds}
                            {--rent_time=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Http test';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $host = rtrim($this->option('host'), '/');
        $country = $this->option('country');
        $service = $this->option('service');
        $rentTime = $this->option('rent_time');

        $this->info('1. Get Number');

        $params = [
            'country' => $country,
            'service' => $service,
        ];

        if (! is_null($rentTime)) {
            $params['rent_time'] = $rentTime;
        }
        $response = Http::get("$host/api/getNumber", $params);

        $data = $response->json();

        if ($response->successful() && $data['code'] === 'ok') {
            $number = $data['number'];
            $activation = $data['activation'];
            $this->info("Number: $number, activation: $activation");
        } else {
            $this->error('Error on getting number: '.json_encode($data));

            return;
        }

        sleep(3);

        $this->info('2. Get State');

        $response = Http::get("$host/api/getStatus", [
            'activation' => $activation,
        ]);
        $data = $response->json();

        if ($response->successful()) {
            $this->info('Статус: '.($data['status'] ?? 'N/A'));
        } else {
            $this->error('Error on getting state: '.json_encode($data));
        }

        sleep(3);
        $this->info('3. Get Sms');

        $maxTries = 10;
        $delay = 5;
        for ($i = 1; $i <= $maxTries; $i++) {
            $this->info("Try $i...");

            $response = Http::get("$host/api/getSms", [
                'activation' => $activation,
            ]);
            $data = $response->json();

            if ($response->successful() && $data['code'] === 'ok') {
                $this->info("📨 SMS: {$data['sms']}");
                break;
            } else {
                $this->warn('No SMS');
                sleep($delay);
            }
        }

        $this->info('4. Cance number');

        $response = Http::get("$host/api/cancelNumber", [
            'activation' => $activation,
        ]);
        $data = $response->json();

        if ($response->successful() && $data['code'] === 'ok') {
            $this->info('Canceled successfully');
        } else {
            $this->error('Error oncanceling: '.json_encode($data));
        }
    }
}
