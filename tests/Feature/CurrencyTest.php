<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Currency;
use Database\Seeders\CurrencySeeder;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CurrencySeeder::class);
    }

    //測試新增匯率
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

    //測試轉換未找到匯率
    public function test_convert_currency_not_found()
    {
        $response = $this->postJson('/api/currency/convert', [
            'from_currency' => 'TWD',
            'to_currency' => 'EUR',
            'amount' => 100
        ]);

        $response->assertStatus(404)
            ->assertJson(['error' => 'Currency conversion not found.']);
    }

    //測試新增匯率資料驗證
    public function test_store_currency_invalid()
    {
        $response = $this->postJson('/api/store', [
            'base_currency' => 'USD',
            'convert_currency' => 'EUR',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['rate']);
    }

    //測試匯率轉換資料驗證
    public function test_convert_currency_invalid()
    {
        $response = $this->postJson('/api/currency/convert', [
            'from_currency' => 'TWD',
            'amount' => 100
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['to_currency']);
    }
}
