<?php

namespace Tests\Feature;

use App\Repository\WatsonRepository;
use Spatie\GoogleCalendar\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WatsonRepositoryTest extends TestCase
{
    protected $repo;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = new WatsonRepository();

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIsTimeSlotFree()
    {
        $response = $this->repo->isTimeSlotFree([
            'date' => '2019-08-15',
            'startTime' => '15:00',
            'minutes' => 60
        ]);

        $this->assertEquals(true, $response);
    }
}
