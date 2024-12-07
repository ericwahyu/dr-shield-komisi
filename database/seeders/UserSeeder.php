<?php

namespace Database\Seeders;

use App\Models\Auth\User;
use App\Models\System\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = User::create([
            'name'     => 'Admin Dr Shield',
            'email'    => 'admin@drshield.com',
            'username' => 'admin',
            'password' => Hash::make('12345678')
        ]);

        $admin->assignRole('admin');

        $ewa = User::create([
            'name'     => 'EWA',
            'email'    => 'erickwahyu19@gmail.com',
            'username' => 'ewa',
            'password' => Hash::make('12345678')
        ]);

        $ewa->assignRole('admin');

        $datas = [
            //Keramik
            [
                'name'                      => 'Asep Sopiyan',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Asep Suhendi',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Fevi',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Agustinus',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Ardiansyah',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Asep Handiyana',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Didi Kartono',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Miftahuri',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Umbara',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Dede Sumarna',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Fernando',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Yustus',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Afatini',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Darwin',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            [
                'name'                      => 'Raden',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 130000000,
                        'value'          => 0.2,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 0.3,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 270000000,
                        'value'          => 0.4,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 340000000,
                        'value'          => 0.5,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 400000000,
                        'value'          => 0.8,
                    ],
                ]
            ],
            //ATAP
            [
                'name'                      => 'Adang Sanusi',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => 923124,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 446000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 356800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 267000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Florete',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 575000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 460000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 345000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Heri Hernawan',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => 923122,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 481000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 384800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 288600000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Mathias Marthinus',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => 923125,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 587000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 469600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 352200000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Rudi Sarjono',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => 923136,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 219000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 175200000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 131400000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Nospa Maulana Liferiandi',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => 923104,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 30000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Novran Yudha Dharmawan',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => 923076,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 250000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 150000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 30000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Panji',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 32000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 24000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Saepuloh',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 30000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Heri',
                'depo'                      => Str::upper('BKS'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 90000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 72000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 54000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Rama',
                'depo'                      => Str::upper('BKS'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 90000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 72000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 54000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Rosadi',
                'depo'                      => Str::upper('BKS'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 90000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 72000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 54000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Tri Yulianto Wibowo',
                'depo'                      => Str::upper('BKS'),
                'civil_registration_number' => 923080,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 90000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 72000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 54000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Budi Setiabudi',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 100000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 80000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 60000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Eko Krismayadi',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 100000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 80000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 60000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Rifal',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 300000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 240000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 180000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 100000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 80000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 60000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Ahmad Hidayat',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 105000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 84000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 63000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Ari Wibowo',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 400000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 320000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 240000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 105000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 84000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 63000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Cipta Priyatna',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => 922190,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 400000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 320000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 240000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 105000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 84000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 63000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Indrawan',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => 923182,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 105000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 84000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 63000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Untung Prayitno',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 105000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 84000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 63000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Dadi Kurniadi',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => 923094,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 403000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 322400000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 241800000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 112000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 89600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 67200000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Dede Amin',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 437000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 349000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 262200000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 112000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 89600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 67200000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Mulyana Hasanudin',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => 923095,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 334000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 267200000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200400000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 112000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 89600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 67200000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Taufik Hidayat',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 437000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 349600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 262200000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 112000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 89600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 67200000,
                        'value'          => 60,
                    ],
                ]
            ],
        ];

        foreach ($datas as $key => $data) {
            $sales = User::create([
                'name' => $data['name'],
            ]);

            $sales->userDetail()->create([
                'civil_registration_number' => $data['civil_registration_number'],
                'depo'                      => $data['depo'],
                'sales_type'                => $data['sales_type'],
                'sales_code'                => strtoupper($data['depo']). ' - ' .explode(' ', $data['name'])[0],
            ]);

            $sales->assignRole('sales');

            foreach ($data['lower_limits'] as $key => $lower_limit) {
                $sales->lowerLimits()->create([
                    'category_id'    => $lower_limit['category_id'],
                    'target_payment' => $lower_limit['target_payment'],
                    'value'          => $lower_limit['value'],
                ]);
            }
        }
    }
}
