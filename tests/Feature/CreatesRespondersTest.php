<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatesResponders extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->login();
    }

    /** @test */
    public function a_user_can_create_a_responder()
    {
        $responderData = [
            'title' => 'Away on Vacation',
            'message' => 'I will be unavailable from the 24th to the 4th.',
            'startDate' => Carbon::now()->toDateTimeString(),
            'endDate' => Carbon::now()->addDays(10)->toDateTimeString(),
            'repoId' => 1
        ];
        $this->postJson('/api/responders', $responderData)->assertStatus(201);
    }

    /** @test */
    public function the_start_date_must_be_before_the_end_date()
    {
        $this->withExceptionHandling();

        $responderData = [
            'title' => 'Away on Vacation',
            'message' => 'I will be unavailable from the 24th to the 4th.',
            'startDate' => Carbon::now()->toDateTimeString(),
            'endDate' => Carbon::now()->subDays(5)->toDateTimeString(),
            'repoId' => 1
        ];

        $this->postJson('/api/responders', $responderData)->assertStatus(422);
    }
}
