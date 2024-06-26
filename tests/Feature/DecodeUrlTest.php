<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DecodeUrlTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test encode url API with an invalid url
     *
     */
    public function test_decode_url_with_invalid_url()
    {
        $request = new Request([
            'url' => 'random url', // invalid url
        ]);

        $response = $this->post(route('decode'), $request->all());
        $responseData = $response->json();

        $response->assertStatus(422);
        $this->assertEquals($responseData['errors']['url'][0], 'The url field must be a valid URL.');
    }

    /**
     * Test decode url API with a valid url
     *
     */
    public function test_decode_url_with_valid_url()
    {
        $urlMapping = Url::factory()->create();

        $request = new Request([
            'url' => config('url_shortening_service.domain_name') . '/' . $urlMapping->short_url
        ]);

        $response = $this->post(route('decode'), $request->all());
        $responseData = $response->json();

        $response->assertStatus(200);
        $this->assertNotNull($responseData['original_url']);
        $this->assertEquals($responseData['original_url'], $urlMapping->original_url);
    }
}
