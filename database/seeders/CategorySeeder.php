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
        $datas = [
            [
                'type' => 'roof',
                'name' => 'Dr Shield',
            ],
            [
                'type' => 'roof',
                'name' => 'Dr Sonne',
            ]
        ];

        foreach ($datas as $key => $data) {
            Category::create([
                'type' => $data['type'],
                'name' => $data['name'],
                'slug' => Str::slug($data['name'])
            ]);
        }
    }
}
