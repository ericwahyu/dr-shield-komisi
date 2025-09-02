<?php

namespace Database\Seeders;


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
            SystemSettingSeeder::class,
            CategorySeeder::class,
            ActualTargetSeeder::class,
            UserSeeder::class,
            DueDateRuleSeeder::class,
            DueDateRuleCeramicSeeder::class,
            DueDateRuleRoofSeeder::class,
            PercentageRegionCommissionSeeder::class,
        ]);
    }
}
