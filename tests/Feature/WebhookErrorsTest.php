<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebhookErrorsTest extends TestCase
{
    public function test_show_error_message_for_inapropriate_parameters()
    {
        $response = $this->withHeaders([
            'Signature' => env('WEBHOOK_CLIENT_SECRET')
        ])->json('POST', 'watson-webhook', [
            'job' => 'IsTimeSlotFree'
        ]);

        $response->assertStatus(422);
    }


    public function test_show_error_message_for_wrong_authentification()
    {
        $response = $this->withHeaders([
            'Signature' => 'wrong'
        ])->json('POST', 'watson-webhook', [
            'job' => 'IsTimeSlotFree'
        ]);

        $response->assertStatus(422);
    }


    public function test_show_error_message_for_missing_authentification()
    {
        $response = $this->withHeaders([])->json('POST', 'watson-webhook', []);

        $response->assertStatus(422);
    }


    public function test_show_error_message_for_missing_job()
    {
        $response = $this->withHeaders([])->json('POST', 'watson-webhook', []);

        $response->assertJson([]);
    }
}
