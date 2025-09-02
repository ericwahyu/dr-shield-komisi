<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PercentageRegionCommission extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'percentage_target'     => 'integer',
        'percentage_commission' => 'float',
    ];
}
