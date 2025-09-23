<?php

namespace App\Services\Export\Commission\Ceramic;

use Carbon\Carbon;
use App\Models\Commission\Commission;

class ExportCeramicCommissionVersion1
{
    protected $export_month;

    public function __construct($export_month)
    {
        //
        $this->export_month = $export_month;
    }

    public function commissionSales($user_id)
    {
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->export_month)->format('Y'))->where('month', (int)Carbon::parse($this->export_month)->format('m'))->where('version', 1)->first();

        return $get_commission;
    }

    public function lowerLimiCommissions($user_id)
    {
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->export_month)->format('Y'))->where('month', (int)Carbon::parse($this->export_month)->format('m'))->where('version', 1)->first();

        if (!$get_commission ) {
            return [];
        }
        return $get_commission?->lowerLimitCommissions()->orderBy('value', 'DESC')->get();
    }

    public function totalCommission($user_id)
    {
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->export_month)->format('Y'))->where('month', (int)Carbon::parse($this->export_month)->format('m'))->where('version', 1)->first();

        if (!$get_commission || $get_commission?->status == 'not-reach') {
            return null;
        }

        return $get_commission?->value_commission;
    }

    //detail commission
    public function getTime($user_id)
    {
        $get_commission = $this->commissionSales($user_id);
        $get_list_years       = $get_commission?->commissionDetails()->orderBy('year', 'ASC')->distinct()->pluck('year')->toArray();
        $get_list_months      = $get_commission?->commissionDetails()->orderBy('month', 'ASC')->distinct()->pluck('month')->toArray();

        $return = [];
        foreach ($get_list_years ?? [] as $key => $year) {
            foreach ($get_list_months ?? [] as $key => $month) {
                $return[] = [
                    'year' => $year,
                    'month' => $month,
                ];
            }
        }

        return $return;
    }

    public function getDetailCommission($user_id, $year, $month, $percentage)
    {
        $get_commission = $this->commissionSales($user_id);
        return $get_commission?->commissionDetails()->where('year', $year)->where('month', $month)->where('percentage_of_due_date', $percentage)->first();
    }

    public function getTotalCommission($user_id, $year, $month, $percentage = [0])
    {
        $get_commission = $this->commissionSales($user_id);
        return $get_commission?->commissionDetails()->when($year, function ($query) use ($year) {
            $query->where('year', $year);
        })->when($month, function ($query) use ($month) {
            $query->where('month', $month);
        })->when($percentage, function ($query) use ($percentage) {
            $query->whereNotIn('percentage_of_due_date', $percentage);
        })->sum('value_of_due_date');
    }

    public function getTotalIncome($user_id, $year, $month, $percentage)
    {
        $get_commission = $this->commissionSales($user_id);
        return $get_commission?->commissionDetails()->when($year, function ($query) use ($year) {
            $query->where('year', $year);
        })->when($month, function ($query) use ($month) {
            $query->where('month', $month);
        })->when($percentage, function ($query) use ($percentage) {
            $query->where('percentage_of_due_date', $percentage);
        })->sum('total_income');
    }
}
