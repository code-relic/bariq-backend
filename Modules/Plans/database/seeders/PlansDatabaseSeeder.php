<?php

namespace Modules\Plans\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Plans\Models\Plans;

class PlansDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plans::factory()->count(10)->create();
    }
}
