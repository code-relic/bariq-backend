<?php

namespace Modules\Plans\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlansFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Plans\Models\Plans::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}

