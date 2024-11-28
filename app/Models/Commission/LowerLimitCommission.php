<?php

namespace App\Models\Commission;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LowerLimitCommission extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id', 'id');
    }

    public function lowerLimit()
    {
        return $this->belongsTo(LowerLimit::class, 'lower_limit_id', 'id');
    }
}
