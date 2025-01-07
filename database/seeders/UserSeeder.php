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
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 373500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 336150000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 298800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 261450000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Asep Suhendi Permana',
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
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 373500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 336150000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 298800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 261450000,
                        'value'          => 70,
                    ],
                ],
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
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 373500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 336150000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 298800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 261450000,
                        'value'          => 70,
                    ],
                ],
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
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 373500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 336150000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 298800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 261450000,
                        'value'          => 70,
                    ],
                ],
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
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 292500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 263250000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 234000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 204750000,
                        'value'          => 70,
                    ],
                ],
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
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 243000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 218700000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 194400000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 170100000,
                        'value'          => 70,
                    ],
                ],
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
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 292500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 263250000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 234000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 204750000,
                        'value'          => 70,
                    ],
                ],
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
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 243000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 218700000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 194400000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 170100000,
                        'value'          => 70,
                    ],
                ],
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
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 292500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 263250000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 234000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 204750000,
                        'value'          => 70,
                    ],
                ],
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
                'depo'                      => Str::upper('BGR'),
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
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 360000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 324000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 288000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 252000000,
                        'value'          => 70,
                    ],
                ],
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
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 382500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 344250000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 306000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 267750000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Dani Rizal',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
            ],
            [
                'name'                      => 'Arie Setiawan Surya',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 180000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 162000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 144000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 126000000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Dede Kurniawan',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 180000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 162000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 144000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 126000000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Dede Kurniawan',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 180000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 162000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 144000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 126000000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'M Yasin',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 180000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 162000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 144000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 126000000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Aga Haitari Prabowo',
                'depo'                      => Str::upper('BKS'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 215000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 193500000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 172000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 150500000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Akhmad Fatoni',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => 923010,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 215000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 193500000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 172000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 150500000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Hendra',
                'depo'                      => Str::upper('BKS'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 215000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 193500000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 172000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 150500000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Didi Suhardi',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 292500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 263250000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 234000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 204750000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Tino',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => null,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 292500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 263250000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 234000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 204750000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Agus Salim',
                'depo'                      => Str::upper('MKS'),
                'civil_registration_number' => 90924065,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 247500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 222750000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 198000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 173250000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Ahmad Yani',
                'depo'                      => Str::upper('MKS'),
                'civil_registration_number' => 90524006,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 225000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 202500000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 180000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 157500000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Akbar',
                'depo'                      => Str::upper('MKS'),
                'civil_registration_number' => 90724039,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 292500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 263250000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 234000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 204750000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Antony Willys Japari',
                'depo'                      => Str::upper('MKS'),
                'civil_registration_number' => 90824050,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 112500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 101250000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 90000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 78750000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Indra Pranatama',
                'depo'                      => Str::upper('MKS'),
                'civil_registration_number' => 90924062,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 292500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 263250000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 234000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 204750000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Daniel Wijaya',
                'depo'                      => Str::upper('SKB'),
                'civil_registration_number' => 90524018,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 281250000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 253125000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 225000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 196875000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Deni Yulianto',
                'depo'                      => Str::upper('SKB'),
                'civil_registration_number' => 90524018,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 303750000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 273375000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 243000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 212625000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Septian Hadi',
                'depo'                      => Str::upper('SKB'),
                'civil_registration_number' => 90524015,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 281250000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 253125000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 225000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 196875000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Windi',
                'depo'                      => Str::upper('SKB'),
                'civil_registration_number' => 90524013,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 303750000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 273375000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 243000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 212625000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'M. Ilham',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => 90524028,
                'sales_type'                => 'ceramic',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 382500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 344250000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 306000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 267750000,
                        'value'          => 70,
                    ],
                ],
            ],

            //ATAP
            [
                'name'                      => 'Adang Sanusi',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => 923124,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 446000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 356800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 267000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 460000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 414000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 368000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 322000000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Floreta',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 575000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 460000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 345000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 475000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 427500000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 380000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 332500000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Heri Hernawan',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => 923122,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 481000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 384800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 288600000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 440000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 424800000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 377600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 330400000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Mathias Marthinus',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => 923125,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 587000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 469600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 352200000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 472000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 424800000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 377600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 330400000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Rudi Sarjono',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => 923136,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 219000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 175200000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 131400000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 424000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 381600000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 339200000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 296800000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Nospa Maulana Liferiandi',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => 923104,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 30000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 732000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 658800000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 585600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 512400000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Novran Yudha Dharmawan',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => 923076,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 250000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 150000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 30000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 596000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 536400000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 476800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 417200000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 60000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Ranu Panji Asmoro',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => 923214,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 32000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 24000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 460000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 414000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 368000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 322000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Saepuloh',
                'depo'                      => Str::upper('BGR'),
                'civil_registration_number' => 923109,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 30000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 596000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 536400000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 476800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 417200000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 60000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Heri',
                'depo'                      => Str::upper('BKS'),
                'civil_registration_number' => 923205,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 90000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 72000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 54000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 800000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 720000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 640000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 560000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 65000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Rama',
                'depo'                      => Str::upper('BKS'),
                'civil_registration_number' => 923203,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 90000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 72000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 54000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 550000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 495000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 440000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 385000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Rosadi',
                'depo'                      => Str::upper('BKS'),
                'civil_registration_number' => 924017,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 90000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 72000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 54000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 626000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 563400000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 500000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 438200000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Tri Yulianto Wibowo',
                'depo'                      => Str::upper('BKS'),
                'civil_registration_number' => 923080,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 90000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 72000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
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
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 100000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 80000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 60000000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Eko Krismayadi',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => 924030,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 350000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 280000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 210000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 100000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 80000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 60000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 380000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 342000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 304000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 266000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Rifal Apriyana',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => 924077,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 300000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 240000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 180000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 100000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 80000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 60000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 370000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 333000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 296000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 259000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Ahmad Hidayat',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => 923207,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 105000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 84000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 63000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 581600000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 523440000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 465280000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 407120000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 29300000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Ari Wibowo',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 400000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 320000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 240000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 105000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 84000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
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
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 400000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 320000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 240000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 105000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 84000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 63000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 830600000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 747540000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 664480000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 581420000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 29300000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Indrawan',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => 923182,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 105000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 84000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 63000000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 581600000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 523440000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 465280000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 407120000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 29300000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Untung Prayitno',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 120000000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 105000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 84000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
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
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 403000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 322400000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 241800000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 112000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 89600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 67200000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 450000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 405000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 360000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 315000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 30200000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Dede Amin',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => 922196,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 437000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 349000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 262200000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 112000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 89600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 67200000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 650000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 585000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 520000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 455000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 42280000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Mulyana Hasanudin',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => 923095,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 334000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 267200000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 200400000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 112000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 89600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 67200000,
                        'value'          => 60,
                    ],
                ],
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 550000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 495000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 440000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 385000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 36240000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Taufik Hidayat',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
                'lower_limits' => [
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 437000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 349600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-shield')->first()?->id,
                        'target_payment' => 262200000,
                        'value'          => 60,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 112000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 89600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 1)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 67200000,
                        'value'          => 60,
                    ],
                ]
            ],
            [
                'name'                      => 'Aji Taufik',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => 90924059,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 180000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 140000000,
                        'value'          => 70,
                    ],
                    // [
                    //     'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                    //     'target_payment' => 36240000,
                    //     'value'          => 100,
                    // ],
                ],
            ],
            [
                'name'                      => 'Arif Hidayat',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => 90924060,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 200000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 180000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 160000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 140000000,
                        'value'          => 70,
                    ],
                ],
            ],
            [
                'name'                      => 'Muhammad Iqbal Kamaruzzaman',
                'depo'                      => Str::upper('BDG'),
                'civil_registration_number' => 90524025,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 212000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 190800000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 169600000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 148400000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 42000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Handi Jayadi',
                'depo'                      => Str::upper('BKS'),
                'civil_registration_number' => 90724040,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 419000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 377100000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 335200000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 293300000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 38000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Asep Saepudin',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => 90624037,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 370000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 333000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 296000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 255000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 55000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Mahmudin',
                'depo'                      => Str::upper('CRB'),
                'civil_registration_number' => 90824048,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 380000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 342000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 304000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 266000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 45000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Anwar Handani',
                'depo'                      => Str::upper('TGR'),
                'civil_registration_number' => null,
                'sales_type'                => 'roof',
            ],
            [
                'name'                      => 'Dadan Supriadi',
                'depo'                      => Str::upper('KRW'),
                'civil_registration_number' => 923094,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 650000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 585000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 520000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 455000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 42280000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Harun Ngaja',
                'depo'                      => Str::upper('MKS'),
                'civil_registration_number' => 90524005,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 199000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 179100000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 159200000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 139300000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 59000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Muh Akbar R',
                'depo'                      => Str::upper('MKS'),
                'civil_registration_number' => 90524007,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 180000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 162000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 144000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 126000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Nurlaila Qadri',
                'depo'                      => Str::upper('MKS'),
                'civil_registration_number' => 91024067,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 180000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 162000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 144000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 126000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Rustan',
                'depo'                      => Str::upper('MKS'),
                'civil_registration_number' => 90624031,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 180000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 162000000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 144000000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 126000000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 50000000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Deri Priatna',
                'depo'                      => Str::upper('SKB'),
                'civil_registration_number' => 90824047,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 136000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 122400000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 108800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 95200000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40500000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Hilmi Abdul Aziz',
                'depo'                      => Str::upper('SKB'),
                'civil_registration_number' => 90524029,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 136000000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 122400000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 108800000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 95200000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40500000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Ridwan Hermawan',
                'depo'                      => Str::upper('SKB'),
                'civil_registration_number' => 90524011,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 235500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 211950000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 188400000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 164850000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40500000,
                        'value'          => 100,
                    ],
                ],
            ],
            [
                'name'                      => 'Rizki Muhammad Ardi',
                'depo'                      => Str::upper('SKB'),
                'civil_registration_number' => 90624035,
                'sales_type'                => 'roof',
                'lower_limits_v2' => [
                    [
                        'category_id'    => null,
                        'target_payment' => 235500000,
                        'value'          => 100,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 211950000,
                        'value'          => 90,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 188400000,
                        'value'          => 80,
                    ],
                    [
                        'category_id'    => null,
                        'target_payment' => 164850000,
                        'value'          => 70,
                    ],
                    [
                        'category_id'    => Category::where('type', 'roof')->where('version', 2)->where('slug', 'dr-sonne')->first()?->id,
                        'target_payment' => 40500000,
                        'value'          => 100,
                    ],
                ],
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

            if (isset($data['lower_limits'])) {
                foreach ($data['lower_limits'] as $key => $lower_limit) {
                    $sales->lowerLimits()->create([
                        'category_id'    => $lower_limit['category_id'],
                        'version'        => 1,
                        'target_payment' => $lower_limit['target_payment'],
                        'value'          => $lower_limit['value'],
                    ]);
                }
            }

            if (isset($data['lower_limits_v2'])) {
                foreach ($data['lower_limits_v2'] as $key => $lower_limit_v2) {
                    $sales->lowerLimits()->create([
                        'category_id'    => $lower_limit_v2['category_id'],
                        'version'        => 2,
                        'target_payment' => $lower_limit_v2['target_payment'],
                        'value'          => $lower_limit_v2['value'],
                    ]);
                }
            }
        }
    }
}
