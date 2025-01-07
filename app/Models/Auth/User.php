<?php

namespace App\Models\Auth;

use App\Models\Commission\Commission;
use App\Models\Commission\LowerLimit;
use App\Models\Commission\SalesCommision;
use App\Models\Invoice\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, SoftDeletes, HasRoles;

    protected $guard_name = 'web';
    protected $guarded    = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'name',
        // 'email',
        // 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function scopeSearch(Builder $query, $term): void
    {
        $term = '%'. $term .'%';

        $query->where(function ($query) use ($term) {
            $query->whereAny(['name'], 'ILIKE', $term)
                ->orWhereHas('userDetail', function ($query) use ($term) {
                    $query->whereAny(['civil_registration_number', 'depo', 'sales_type', 'sales_code'], 'ILIKE', $term);
                });
        });
    }

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id', 'id');
    }

    public function lowerLimits()
    {
        return $this->hasMany(LowerLimit::class, 'user_id', 'id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'user_id', 'id');
    }
}
