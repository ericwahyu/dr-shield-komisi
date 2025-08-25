<?php

namespace App\Models\System;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataReset extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'data_reset' => 'date',
        'date_reset' => 'date',
    ];

    public function scopeSearch(Builder $query, $term): void
    {
        $term = '%'. $term .'%';

        $query->where(function ($query) use ($term) {
            $query->whereAny(['data_reset', 'note', 'date_reset'], 'ILIKE', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    $query->whereAny(['name'], 'ILIKE', $term)
                        ->orWhereHas('userDetail', function ($query) use ($term) {
                            $query->whereAny(['civil_registration_number', 'depo', 'sales_type', 'sales_code'], 'ILIKE', $term);
                        });
                });
        });
    }

    /**
     * Get the user that owns the DataReset
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
