<?php

namespace App\Models\Invoice;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function scopeSearch(Builder $query, $term): void
    {
        $term = '%'. $term .'%';

        $query->where(function ($query) use ($term) {
            $query->whereAny(['invoice_number', 'id_customer', 'customer'], 'ILIKE', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    $query->whereAny(['name'], 'ILIKE', $term)
                        ->orWhereHas('userDetail', function ($query) use ($term) {
                            $query->whereAny(['civil_registration_number', 'depo', 'sales_type', 'sales_code'], 'ILIKE', $term);
                        });
                });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id');
    }

    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetail::class, 'invoice_id', 'id');
    }

    public function dueDateRules()
    {
        return $this->hasMany(DueDateRule::class, 'invoice_id', 'id');
    }
}
