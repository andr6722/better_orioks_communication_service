<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BannerControllerTest extends TestCase
{

    public function testStoreSuccess()
    {
        $data = [
            "start_date" => "2024-05-01",
            "end_date" => "2024-05-30",
            "group" => "B",
            "banner_type" => "Large",
            "title" => "Наш новый баннер",
            "banner_text" => "Это текст нашего нового баннера, который привлекает внимание."
        ];

        $response = $this->json('POST', 'api/v1/banners', $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Banner success save', 'data' => $data['banner_type'], $data['title'], $data['banner_text']]);
    }
    public function testGroupsSuccess()
    {
        $response = $this->json('GET', 'api/v1/banners/C');
        $response->assertStatus(200)
            ->assertJsonFragment(["[]"]);
    }
}
