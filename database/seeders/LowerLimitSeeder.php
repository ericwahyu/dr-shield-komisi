<?php

namespace Database\Seeders;

use App\Models\Commission\LowerLimit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LowerLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $datas = [
            [
                'type'           => 'ceramic',
                'target_payment' => 130000000,
                'value'          => 0.2,
            ],
            [
                'type'           => 'ceramic',
                'target_payment' => 200000000,
                'value'          => 0.3,
            ],
            [
                'type'           => 'ceramic',
                'target_payment' => 270000000,
                'value'          => 0.4,
            ],
            [
                'type'           => 'ceramic',
                'target_payment' => 340000000,
                'value'          => 0.5,
            ],
            [
                'type'           => 'ceramic',
                'target_payment' => 400000000,
                'value'          => 0.8,
            ],
        ];

        foreach ($datas as $key => $data) {
            LowerLimit::create([
                'type'           => $data['type'],
                'number'         => $key,
                'target_payment' => $data['target_payment'],
                'value'          => $data['value'],
            ]);
        }
    }
}
