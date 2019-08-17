<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WatsonControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testWebhookDirect()
    {
        $response = $this->withHeaders([
            'Signature' => env('WEBHOOK_CLIENT_SECRET')
        ])->json('POST', 'watson-webhook', [
            'job' => 'test',
            'parameter' => 1
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 1]);
    }


    public function testWebhookQueued()
    {
        $response = $this->withHeaders([
            'Signature' => env('WEBHOOK_CLIENT_SECRET')
        ])->json('POST', 'watson-webhook', [
            'job' => 'queuedTest',
            'parameter' => 1
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'ok'
            ]);
    }
}
