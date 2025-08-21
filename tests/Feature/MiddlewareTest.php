<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;

class MiddlewareTest extends TestCase
{
    public function test_middleware()
    {
        $response = $this->withHeaders([
            'Authorization' => config('app.secret'),
        ])->get(route('series.test'));

        $response->assertStatus(200);

        $expected = [
            'status' => 'success',
            'message' => 'Connected',
            'data' => null,
        ];

        $this->assertEquals($expected, $response->json('data.response'));
    }

    public function test_middleware_without_token()
    {
        $response = $this->withoutToken()->get(route('series.test'));

        $response->assertStatus(403);

        $expected = [
            'status' => 'unauthorized',
            'message' => 'Unauthorized: Invalid token',
            'data' => null,
        ];

        $this->assertEquals($expected, $response->json('data.response'));
    }

    public function test_middleware_with_wrong_token()
    {
        $response = $this->noToken()->get(route('series.test'));

        $response->assertStatus(403);

        $expected = [
            'status' => 'unauthorized',
            'message' => 'Unauthorized: Invalid token',
            'data' => null,
        ];

        $this->assertEquals($expected, $response->json('data.response'));
    }

    public function test_middleware_with_missing_secret_env()
    {
        Config::set('app.secret', null);

        $response = $this->get(route('series.test'));

        $response->assertStatus(500);

        $expected = [
            'status' => 'error',
            'message' => 'No secret found in the ENV file',
            'data' => null,
        ];

        $this->assertEquals($expected, $response->json('data.response'));
    }
}
