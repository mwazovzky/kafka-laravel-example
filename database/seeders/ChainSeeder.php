<?php

namespace Database\Seeders;

use App\Models\Chain;
use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChainSeeder extends Seeder
{
    use WithoutModelEvents;

    private const FILE = __DIR__.'/data/currencies.json';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(
            file_get_contents(self::FILE),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );

        foreach ($data as $item) {
            $currency = Currency::where('iso', $item['base_currency'])
                ->firstOrFail();

            Chain::factory()
                ->for($currency)
                ->create(['name' => $item['name']]);
        }
    }
}
