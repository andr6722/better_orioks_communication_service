<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PushNotificationControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSendNotificationSuccess()
    {
        $data = [
            'user_id' => '12345',
            'subject_name' => 'Math',
            'control_event_name' => 'Test_1',
            'current_score' => '2',
            'new_score' => '4'
        ];

        $response = $this->json('POST', '/api/v1/notifications', $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['Предмет: Math, КМ Test_1. Оценка изменена с 2, на 4']);
    }
    public function testNewsSuccess()
    {
        $data = [
            'user_id' => '12345',
            'NewsName' => 'Big News!',
            'link' => 'http://example.com'
        ];

        $response = $this->json('POST', 'api/v1/news', $data);
        $response->assertStatus(200)
            ->assertJsonFragment(['Big News!']);

    }
}
