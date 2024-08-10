<?php

namespace Modules\Users\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Users\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('12345'),
            'is_2fa_enabled' => $this->faker->boolean(),
        ];
    }
}