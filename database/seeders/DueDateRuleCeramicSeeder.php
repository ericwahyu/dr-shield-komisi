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
        $datas = [
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

        foreach ($datas as $key => $data) {
            DueDateRuleCeramic::create([
                'type'     => $data['type'],
                'number'   => $key,
                'due_date' => $data['due_date'],
                'value'    => $data['value'],
            ]);
        }
    }
}
