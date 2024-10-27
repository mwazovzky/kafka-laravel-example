<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Chain;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Operation;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationSeeder extends Seeder
{
    use WithoutModelEvents;

    private const COUNT = 5;

    private const CLIENT = 1;

    private const CHAIN = 'ethereum';

    private const CURRENCY = 'USDT';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chain = Chain::where('name', self::CHAIN)->first();
        $currency = Currency::where('iso', self::CURRENCY)->first();
        $client = Client::find(self::CLIENT);

        $addresses = Address::query()
            ->where('chain_id', $chain->id)
            ->where('client_id', $client->id)
            ->get();

        foreach ($addresses as $address) {
            $operations = Operation::factory()
                ->count(rand(0, self::COUNT))
                ->create();

            foreach ($operations as $operation) {
                $transactions = Transaction::factory()
                    ->for($chain)
                    ->for($currency)
                    ->for($address)
                    ->withFee()
                    ->count(1)
                    ->create();

                $operation->transactions()->attach($transactions);
            }
        }
    }
}
