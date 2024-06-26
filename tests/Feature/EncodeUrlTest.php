<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EncodeUrlTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test encode url API with an invalid url
     *
     */
    public function test_encode_url_with_invalid_url()
    {
        $request = new Request([
            'url' => 'random url', // invalid url
        ]);

        $response = $this->post(route('encode'), $request->all());
        $responseData = $response->json();

        $response->assertStatus(422);
        $this->assertEquals($responseData['errors']['url'][0], 'The url field must be a valid URL.');
    }

    /**
     * Test encode url API with a valid url
     *
     */
    public function test_encode_url_with_valid_url()
    {
        $request = new Request([
            'url' => 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too', // valid url
        ]);

        $response = $this->post(route('encode'), $request->all());
        $responseData = $response->json();

        $response->assertStatus(200);
        $this->assertNotNull($responseData['short_url']);
        $this->assertStringContainsString(config('url_shortening_service.domain_name') . '/', $responseData['short_url']);
    }
}
