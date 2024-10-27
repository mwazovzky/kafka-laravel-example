<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    use WithoutModelEvents;

    private const CURRENCIES = [
        'ETH',
        'BTC',
        'XRP',
        'USDT',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::CURRENCIES as $iso) {
            Currency::factory()->create([
                'iso' => $iso,
            ]);
        }
    }
}
