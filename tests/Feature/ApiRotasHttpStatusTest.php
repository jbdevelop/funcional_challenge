<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiRotasHttpStatusTest extends TestCase
{
    public function rotasProvider() {
        return [
            ['get','api/saldo'],
            ['put','api/depositar'],
            ['put','api/sacar']
        ];
    }

    /**
     * @dataProvider rotasProvider
     */
    public function testApiRotasHttpStatus($metodo, $rota)
    {
        $response = $this->$metodo($rota);
        $response->assertStatus(200);
    }
}
