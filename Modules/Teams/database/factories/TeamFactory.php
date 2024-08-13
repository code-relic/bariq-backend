<?php

namespace Modules\Teams\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Plans\Models\Plans;
use Modules\Teams\Models\Team;
use Modules\Users\Models\User;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'owner_id' => User::factory(), // This will create a new User and set it as the owner
            'plans_id' => Plans::factory(),

        ];
    }
}

