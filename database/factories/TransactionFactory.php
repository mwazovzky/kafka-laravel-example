<?php

namespace Database\Factories;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Address;
use App\Models\Chain;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(TransactionType::cases()),
            'status' => $this->faker->randomElement(TransactionStatus::cases()),
            'txid' => $this->faker->uuid(),
            'vout' => $this->faker->randomNumber(1),
            'address_id' => Address::factory(),
            'chain_id' => Chain::factory(),
            'currency_id' => Currency::factory(),
            'amount' => $this->faker->randomNumber(8) / 10 ** 4,
        ];
    }

    public function withFee(): static
    {
        return $this->afterCreating(function (Transaction $transaction) {
            $transaction->update([
                'fee_currency_id' => $transaction->chain->chain_currency_id,
                'amount' => $this->faker->randomNumber(6) / 10 ** 4,
            ]);
        });
    }
}
