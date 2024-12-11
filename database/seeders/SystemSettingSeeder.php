<?php

namespace Database\Seeders;

use App\Models\System\SystemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $sudo_password = Hash::make('sudoericwa87435');

        SystemSetting::create([
            'value_of_total_income' => 1.11,
            'value_incentive'       => 0.5,
            'sudo_password'         => $sudo_password,
        ]);
    }
}
