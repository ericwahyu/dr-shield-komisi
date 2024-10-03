<?php

namespace Database\Seeders;

use App\Models\Invoice\DueDateCeramicRule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DueDateCeramicRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $datas = [
            [
                'type'     => 'ceramic',
                'due_date' => 75,
                'value'    => 20,
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

        foreach ($datas as $key => $data) {
            DueDateCeramicRule::create([
                'type'     => $data['type'],
                'number'   => $key + 1,
                'due_date' => $data['due_date'],
                'value'    => $data['value'],
            ]);
        }
    }
}
