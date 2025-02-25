<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Currency;

class CurrencyTest extends TestCase
{   
    //測試新增貨幣
    public function test_store_currency()
    {
        $response = $this->postJson('/api/store', [
            'base_currency' => 'USD',
            'convert_currency' => 'EUR',
            'rate' => 0.85
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'base_currency' => 'USD',
                'convert_currency' => 'EUR',
                'rate' => 0.85
            ]);
    }

    //測試獲取所有貨幣
    public function test_get_currency()
    {
        $response = $this->getJson('/api/currency');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'base_currency',
                    'last_updated',
                    'rates'
                ]
            ]);
    }

    //測試匯率轉換
    public function test_convert_currency()
    {
        $response = $this->postJson('/api/currency/convert', [
            'from_currency' => 'USD',
            'to_currency' => 'TWD',
            'amount' => 100
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'from_currency' => 'USD',
                'to_currency' => 'TWD',
                'amount' => 100,
                'converted_amount' => 3150,
                'rate' => 31.5
            ]);
    }
}
