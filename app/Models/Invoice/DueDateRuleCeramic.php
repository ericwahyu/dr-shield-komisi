<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DueDateRuleCeramic extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];
}
