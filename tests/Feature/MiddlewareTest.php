<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\DataProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class MiddlewareTest extends BaseTestCase
{
    #[DataProvider('middlewareProvider')]
    public function test_middleware($token, $exepectedStatusCode, $expectedData)
    {
        if ($token != null) {
            $headers = [
                'Authorization' => $token,
            ];
        }
        $response = $this->withHeaders($headers ?? [])->get(route('series.test'));

        $response->assertStatus($exepectedStatusCode);

        $this->assertEquals($expectedData, $response->json('data.response'));
    }

    public static function middlewareProvider()
    {
        return [
            'valid token' => [
                'test-secret',
                200,
                [
                    'status' => 'success',
                    'message' => 'Connected',
                    'data' => null,
                ]
            ],
            'wrong token' => [
                4321,
                403,
                [
                    'status' => 'unauthorized',
                    'message' => 'Unauthorized: Invalid token',
                    'data' => null,
                ]
            ],
            'no token' => [
                null,
                403,
                [
                    'status' => 'unauthorized',
                    'message' => 'Unauthorized: Invalid token',
                    'data' => null,
                ]
            ],
        ];
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
