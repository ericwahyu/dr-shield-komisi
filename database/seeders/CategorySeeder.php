<?php

namespace Database\Seeders;

use App\Models\System\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $datas_v1 = [
            // [
            //     'type' => 'roof',
            //     'name' => 'Dr Shield',
            // ],
            // [
            //     'type' => 'roof',
            //     'name' => 'Dr Sonne',
            // ],
            [
                'type' => 'roof',
                'name' => 'Dr Houz',
            ]
        ];

        foreach ($datas_v1 as $key => $data) {
            Category::create([
                'type'    => $data['type'],
                'version' => 1,
                'name'    => $data['name'],
                'slug'    => Str::slug($data['name'])
            ]);
        }

        $datas_v2 = [
            // [
            //     'type' => 'roof',
            //     'name' => 'Dr Shield',
            // ],
            [
                'type' => 'roof',
                'name' => 'Dr Sonne',
            ],
            // [
            //     'type' => 'roof',
            //     'name' => 'Dr Houze',
            // ]
        ];

        foreach ($datas_v2 as $key => $data) {
            Category::create([
                'type'    => $data['type'],
                'version' => 2,
                'name'    => $data['name'],
                'slug'    => Str::slug($data['name'])
            ]);
        }
    }
}
