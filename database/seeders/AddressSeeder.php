<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Chain;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    use WithoutModelEvents;

    private const COUNT = 20;

    private const CLIENT = 1;

    private const CHAIN = 'ethereum';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chain = Chain::where('name', self::CHAIN)->first();
        $client = Client::find(self::CLIENT);

        Address::factory()
            ->count(self::COUNT)
            ->for($chain)
            ->for($client)
            ->create();
    }
}
