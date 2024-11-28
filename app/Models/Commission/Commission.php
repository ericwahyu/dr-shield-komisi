<?php

namespace App\Models\Commission;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lowerLimitCommissions()
    {
        return $this->hasMany(LowerLimitCommission::class, 'commission_id', 'id');
    }

    public function commissionDetails()
    {
        return $this->hasMany(CommissionDetail::class, 'commission_id', 'id');
    }

    public function actualTargets()
    {
        return $this->hasMany(ActualTarget::class, 'actual_target_id', 'id');
    }
}
