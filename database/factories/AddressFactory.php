<?php

namespace Database\Factories;

use App\Enums\AddressStatus;
use App\Enums\AddressType;
use App\Models\Chain;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(AddressType::cases()),
            'status' => $this->faker->randomElement(AddressStatus::cases()),
            'hash' => $this->faker->uuid(),
            'chain_id' => Chain::factory(),
            'client_id' => Client::factory(),
        ];
    }
}
