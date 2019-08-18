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
            'job' => 'test1',
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
            'job' => 'Test',
            'parameter' => 1
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'ok'
            ]);
    }


    public function testIsTimeSlotFree()
    {
        $response = $this->withHeaders([
            'Signature' => env('WEBHOOK_CLIENT_SECRET')
        ])->json('POST', 'watson-webhook', [
            'job' => 'isTimeSlotFree',
            'date' => '2019-08-15',
            'startTime' => '15:00',
            'minutes' => 60
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => true
            ]);
    }
}
