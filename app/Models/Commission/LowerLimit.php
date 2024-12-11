<?php

namespace App\Models\Commission;

use App\Models\Auth\User;
use App\Models\System\Category;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LowerLimit extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lowerLimitCommissions()
    {
        return $this->hasMany(LowerLimitCommission::class, 'lower_limit_id', 'id');
    }
}
