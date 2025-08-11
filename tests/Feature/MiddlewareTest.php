<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use App\Http\Resources\ResponseResource;

class MiddlewareTest extends TestCase
{
    public function test_middleware()
    {
        $response = $this->withHeaders([
            'Authorization' => config('app.secret'),
        ])->get(route('series.test'));

        $response->assertStatus(200);

        $this->assertEquals(
            ResponseResource::CONNECTED,
            $response->json('data.response')
        );
    }

    public function test_middleware_without_token()
    {
        $response = $this->get(route('series.test'));

        $response->assertStatus(403);

        $this->assertEquals(
            ResponseResource::UNAUTHORIZED,
            $response->json('data.response')
        );
    }

    public function test_middleware_with_missing_secret_env()
    {
        Config::set('app.secret', null);

        $response = $this->get(route('series.test'));

        $response->assertStatus(500);

        $this->assertEquals(
            ResponseResource::NOTOKEN,
            $response->json('data.response')
        );
    }
}
