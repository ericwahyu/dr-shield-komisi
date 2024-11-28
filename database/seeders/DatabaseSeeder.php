<?php

namespace Database\Seeders;

use App\Models\Invoice\DueDateRule;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            DueDateRuleSeeder::class,
            DueDateRuleCeramicSeeder::class,
            ActualTargetSeeder::class,
            SystemSettingSeeder::class,
        ]);
    }
}
