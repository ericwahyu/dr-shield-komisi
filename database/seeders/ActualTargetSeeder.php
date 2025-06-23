<?php

namespace Database\Seeders;

use App\Models\Commission\ActualTarget;
use App\Models\System\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActualTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $datas = [
            //1
            [
                'type'             => 'roof',
                'category'         => 'dr-shield',
                'target'           => 400000000,
                'actual'           => 100,
                'value_commission' => 4000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-shield',
                'target'           => 400000000,
                'actual'           => 80,
                'value_commission' => 2500000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-shield',
                'target'           => 300000000,
                'actual'           => 100,
                'value_commission' => 4000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-shield',
                'target'           => 300000000,
                'actual'           => 80,
                'value_commission' => 2500000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-shield',
                'target'           => 200000000,
                'actual'           => 100,
                'value_commission' => 4000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-shield',
                'target'           => 200000000,
                'actual'           => 80,
                'value_commission' => 2500000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-shield',
                'target'           => 100000000,
                'actual'           => 100,
                'value_commission' => 4000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-shield',
                'target'           => 100000000,
                'actual'           => 80,
                'value_commission' => 2500000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-sonne',
                'target'           => 200000000,
                'actual'           => 100,
                'value_commission' => 4000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-sonne',
                'target'           => 200000000,
                'actual'           => 80,
                'value_commission' => 2500000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-sonne',
                'target'           => 150000000,
                'actual'           => 100,
                'value_commission' => 4000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-sonne',
                'target'           => 150000000,
                'actual'           => 80,
                'value_commission' => 2500000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-sonne',
                'target'           => 100000000,
                'actual'           => 100,
                'value_commission' => 4000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-sonne',
                'target'           => 100000000,
                'actual'           => 80,
                'value_commission' => 2500000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-sonne',
                'target'           => 50000000,
                'actual'           => 100,
                'value_commission' => 4000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-sonne',
                'target'           => 50000000,
                'actual'           => 80,
                'value_commission' => 2500000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-houz',
                'target'           => 220000000,
                'actual'           => 100,
                'value_commission' => 2000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-houz',
                'target'           => 220000000,
                'actual'           => 80,
                'value_commission' => 1250000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-houz',
                'target'           => 200000000,
                'actual'           => 100,
                'value_commission' => 2000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-houz',
                'target'           => 200000000,
                'actual'           => 80,
                'value_commission' => 1250000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-houz',
                'target'           => 160000000,
                'actual'           => 100,
                'value_commission' => 2000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-houz',
                'target'           => 160000000,
                'actual'           => 80,
                'value_commission' => 1250000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-houz',
                'target'           => 70000000,
                'actual'           => 100,
                'value_commission' => 2000000,
            ],
            [
                'type'             => 'roof',
                'category'         => 'dr-houz',
                'target'           => 70000000,
                'actual'           => 80,
                'value_commission' => 1250000,
            ],

        ];

        foreach ($datas as $key => $data) {
            ActualTarget::create([
                'category_id'      => Category::where('type', $data['type'])->where('slug', Str::slug($data['category']))->first()?->id,
                'target'           => $data['target'],
                'actual'           => $data['actual'],
                'value_commission' => $data['value_commission'],
            ]);
        }
    }
}
