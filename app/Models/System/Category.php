<?php

namespace App\Models\System;

use App\Models\Commission\ActualTarget;
use App\Models\Commission\Commission;
use App\Models\Commission\LowerLimit;
use App\Models\Commission\LowerLimitCommission;
use App\Models\Invoice\InvoiceDetail;
use App\Models\Invoice\PaymentDetail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    public function lowerLimis()
    {
        return $this->hasMany(LowerLimit::class, 'category_id', 'id');
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'category_id', 'id');
    }

    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetail::class, 'category_id', 'id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'category_id', 'id');
    }

    public function lowerLimitCommissions()
    {
        return $this->hasMany(LowerLimitCommission::class, 'category_id', 'id');
    }

    public function actualTargets()
    {
        return $this->hasMany(ActualTarget::class, 'category_id', 'id');
    }
}
