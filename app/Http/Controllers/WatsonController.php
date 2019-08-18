<?php


namespace App\Http\Controllers;


use App\Http\Requests\WebhookRequest;
use App\Http\Webhooks\WatsonSignatureValidator;
use App\Http\Webhooks\WatsonWebhookProfile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookProcessor;

class WatsonController
{


    public function __invoke(WebhookRequest $request)
    {
        $method = $this->method($request);

        if ( $this->isRepo($method) )
            return response()->json((new $method($request))->handle());

        return response()->json($this->queuedJob($method, $request));
    }



    private function queuedJob($job, $request)
    {
        $webhookConfig = new WebhookConfig([
            'name' => 'Watson',
            'signing_secret' => env('WEBHOOK_CLIENT_SECRET'),
            'signature_header_name' => 'Signature',
            'signature_validator' => WatsonSignatureValidator::class,
            'webhook_profile' => WatsonWebhookProfile::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'process_webhook_job' => $job,
        ]);

        (new WebhookProcessor($request, $webhookConfig))->process();

        return ['message' => 'ok'];
    }


    /**
     * Returns the method defined for the job.
     *
     * @param $request
     * @return mixed
     */
    private function method($request)
    {
        $job = ucfirst(Str::camel($request->get('job')));

        return Config::get('webhook.jobs.' . $job);
    }


    /**
     * Check if the method is defined as repository for immediate feedback.
     *
     * @param $method
     * @return bool
     */
    private function isRepo($method)
    {
        return substr($method, 4, 10) == 'Repository';
    }
}
