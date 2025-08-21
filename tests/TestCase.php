<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeaders([
            'Authorization' => config('app.secret'),
        ]);
    }

    protected function noToken()
    {
        $this->defaultHeaders = [];
        return $this;
    }

    protected function wrongToken()
    {
        $this->defaultHeaders = ['wrong-token'];
        return $this;
    }
}
