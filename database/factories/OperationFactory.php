<?php

namespace Database\Factories;

use App\Enums\OperationStatus;
use App\Enums\OperationType;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Operation>
 */
class OperationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(OperationType::cases()),
            'status' => $this->faker->randomElement(OperationStatus::cases()),
            'client_id' => Client::factory(),
        ];
    }
}
