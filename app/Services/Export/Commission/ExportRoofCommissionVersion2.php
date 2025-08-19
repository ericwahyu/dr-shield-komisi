<?php

namespace App\Services\Export\Commission;

use Carbon\Carbon;
use App\Models\System\Category;
use App\Models\Commission\Commission;

class ExportRoofCommissionVersion2
{
    /**
     * Create a new class instance.
     */
    protected $export_month;

    public function __construct($export_month)
    {
        //
        $this->export_month = $export_month;
    }

    public function commissionSales($user_id, $category)
    {
        $category = $category != null ? Category::where('slug', $category)->where('version', 2)->first() : $category;
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->export_month)->format('Y'))->where('month', (int)Carbon::parse($this->export_month)->format('m'))
        ->when($category != null, function ($query) use ($category) {
            $query->where('category_id', $category?->id);
        })->when($category == null, function ($query) use ($category) {
            $query->whereNull('category_id');
        })->where('version', 2)->first();

        return $get_commission;
    }

    public function lowerLimiCommissions($user_id, $category)
    {
        $category = $category != null ? Category::where('slug', $category)->where('version', 2)->first() : $category;
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->export_month)->format('Y'))->where('month', (int)Carbon::parse($this->export_month)->format('m'))
         ->when($category != null, function ($query) use ($category) {
            $query->where('category_id', $category?->id);
        })->when($category == null, function ($query) use ($category) {
            $query->whereNull('category_id');
        })->where('version', 2)->first();
        // dd($user_id, $category, $get_commission);

        if (!$get_commission ) {
            return [];
        }
        return $get_commission?->lowerLimitCommissions()->orderBy('value', 'DESC')->get();
    }

    public function totalCommission($user_id, $category)
    {
        $category = $category != null ? Category::where('slug', $category)->where('version', 2)->first() : $category;
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->export_month)->format('Y'))->where('month', (int)Carbon::parse($this->export_month)->format('m'))
         ->when($category != null, function ($query) use ($category) {
            $query->where('category_id', $category?->id);
        })->when($category == null, function ($query) use ($category) {
            $query->whereNull('category_id');
        })->where('version', 2)->first();

        if (!$get_commission || $get_commission?->status == 'not-reach') {
            return null;
        }

        return $get_commission?->commissionDetails()->whereNotIn('percentage_of_due_date', [0])->sum('value_of_due_date');
    }

    public function commissionDetail($user_id, $category, $percentage_of_due_date = 0)
    {
        $get_commission = $this->commissionSales($user_id, $category);

        return $get_commission?->commissionDetails()->where('percentage_of_due_date', $percentage_of_due_date)->first();
    }
}
