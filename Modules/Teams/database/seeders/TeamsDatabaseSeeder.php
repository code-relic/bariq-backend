<?php

namespace Modules\Teams\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Teams\Models\Team;

class TeamsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Number of teams to seed
        $numberOfTeams = 300;

        for ($i = 0; $i < $numberOfTeams; $i++) {
            Team::create([
                'name' => 'Team ' . $i,
                "owner_id" => 1,
                "plans_id" => 0
            ]);
        }
    }
}
