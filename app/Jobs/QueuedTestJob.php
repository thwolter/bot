<?php

namespace App\Jobs;

use Spatie\WebhookClient\ProcessWebhookJob;
use Illuminate\Support\Facades\Log;

class QueuedTestJob extends ProcessWebhookJob
{

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('job can be performed');

        Log::info($this->webhookCall);
    }
}
