<?php


namespace App\Http\Controllers;


use App\Http\Webhooks\WatsonSignatureValidator;
use App\Http\Webhooks\WatsonWebhookProfile;
use App\Repository\WatsonRepository;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;

class WatsonController
{

    private $repo;


    public function __construct(WatsonRepository $repo)
    {
        $this->repo = $repo;
    }


    public function __invoke(Request $request)
    {

        $job = $request->get('job');

        if (method_exists(WatsonRepository::class, $job))
            return response()->json($this->repo->$job($request->except('job')));

        $queuedJob = 'App\Jobs\\' . ucfirst($job) . 'Job';
        if (class_exists($queuedJob))
            return response()->json($this->queuedJob($queuedJob, $request));

        abort(303, 'Job not defined.');
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

        (new \Spatie\WebhookClient\WebhookProcessor($request, $webhookConfig))->process();

        return ['message' => 'ok'];
    }
}
