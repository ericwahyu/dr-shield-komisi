<?php

namespace Database\Seeders;

use App\Models\Invoice\DueDateRuleRoof;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DueDateRuleRoofSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $datas_v2 = [
            [
                'type'     => 'roof',
                'due_date' => 0,
                'value'    => 100,
            ],
            [
                'type'     => 'roof',
                'due_date' => 15,
                'value'    => 50,
            ],
            [
                'type'     => 'roof',
                'due_date' => 22,
                'value'    => 0,
            ],
        ];

        foreach ($datas_v2 as $key => $data) {
            DueDateRuleRoof::create([
                'type'     => $data['type'],
                'version'  => 2,
                'due_date' => $data['due_date'],
                'value'    => $data['value'],
            ]);
        }
    }
}
