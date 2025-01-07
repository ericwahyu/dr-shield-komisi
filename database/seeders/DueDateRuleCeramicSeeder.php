<?php

namespace Database\Seeders;

use App\Models\Invoice\DueDateRuleCeramic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DueDateRuleCeramicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $datas_v1 = [
            [
                'type'     => 'ceramic',
                'due_date' => 0,
                'value'    => 100,
            ],
            [
                'type'     => 'ceramic',
                'due_date' => 75,
                'value'    => 80,
            ],
            [
                'type'     => 'ceramic',
                'due_date' => 90,
                'value'    => 50,
            ],
            [
                'type'     => 'ceramic',
                'due_date' => 100,
                'value'    => 0,
            ],
        ];

        foreach ($datas_v1 as $key => $data) {
            DueDateRuleCeramic::create([
                'type'     => $data['type'],
                'version'  => 1,
                'due_date' => $data['due_date'],
                'value'    => $data['value'],
            ]);
        }

        $datas_v2 = [
            [
                'type'     => 'ceramic',
                'due_date' => 0,
                'value'    => 100,
            ],
            [
                'type'     => 'ceramic',
                'due_date' => 15,
                'value'    => 50,
            ],
            [
                'type'     => 'ceramic',
                'due_date' => 22,
                'value'    => 0,
            ],
        ];

        foreach ($datas_v2 as $key => $data) {
            DueDateRuleCeramic::create([
                'type'     => $data['type'],
                'version'  => 2,
                'due_date' => $data['due_date'],
                'value'    => $data['value'],
            ]);
        }
    }
}
