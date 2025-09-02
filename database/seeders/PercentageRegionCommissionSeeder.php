<?php

namespace Database\Seeders;

use App\Models\System\PercentageRegionCommission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PercentageRegionCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $datas = [
            [
                'type'                  => 'roof',
                'percentage_target'     => 100,
                'percentage_commission' => 0.30,
            ],
            [
                'type'                  => 'roof',
                'percentage_target'     => 90,
                'percentage_commission' => 0.25,
            ],
            [
                'type'                  => 'roof',
                'percentage_target'     => 80,
                'percentage_commission' => 0.20,
            ],
            [
                'type'                  => 'roof',
                'percentage_target'     => 70,
                'percentage_commission' => 0.15,
            ],
            [
                'type'                  => 'ceramic',
                'percentage_target'     => 100,
                'percentage_commission' => 0.35,
            ],
            [
                'type'                  => 'ceramic',
                'percentage_target'     => 90,
                'percentage_commission' => 0.30,
            ],
            [
                'type'                  => 'ceramic',
                'percentage_target'     => 80,
                'percentage_commission' => 0.25,
            ],
            [
                'type'                  => 'ceramic',
                'percentage_target'     => 70,
                'percentage_commission' => 0.20,
            ],
        ];

        foreach ($datas as $key => $data) {
            PercentageRegionCommission::create([
                'type'                  => $data['type'],
                'percentage_target'     => $data['percentage_target'],
                'percentage_commission' => $data['percentage_commission'],
            ]);
        }
    }
}
