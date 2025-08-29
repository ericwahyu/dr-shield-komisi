<?php

namespace App\Livewire\Commission\RegionCommission;

use App\Models\Auth\UserDetail;
use App\Services\Commission\RegionCommissionService;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Throwable;

class RegionCommissionCreate extends Component
{
    use LivewireAlert;
    public $roof_region, $ceramic_region;
    public $generate_month, $roof_region_select, $ceramic_region_select, $roof_target, $ceramic_target;
    public $data_roof_region = [], $data_ceramic_region = [];

    public function render()
    {

        return view('livewire.commission.region-commission.region-commission-create', [
            'data_roof_region' => $this->data_roof_region,
        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount()
    {
        $this->roof_region = UserDetail::where('sales_type', 'roof')->distinct()->pluck('depo')->toArray();
        $this->ceramic_region = UserDetail::where('sales_type', 'ceramic')->distinct()->pluck('depo')->toArray();
    }

    public function addDataRegion($type)
    {
        // dd('asasasa');
        $this->validate(
            [
                $type.'_region_select' => 'required',
                $type.'_target'        => 'required|numeric',
            ],
            [
                $type.'_region_select.required' => 'Wilayah wajib diisi',
                $type.'_target.required'        => 'Nominal Target wajib diisi',
                $type.'_target.numeric'         => 'Nominal Target harus berupa angka',
            ]
        );

        try {
            if ($type == 'roof') {
                $this->data_roof_region[$this->roof_region_select] = [
                    100 => (int)$this->roof_target
                ];
            } elseif ($type == 'ceramic') {
                $this->data_ceramic_region[$this->ceramic_region_select] = [
                    100 => (int)$this->ceramic_target
                ];
            }
        } catch (Exception | Throwable $th) {
        }

        // dd( $this->data_roof_region);
        $this->reset('roof_region_select', 'ceramic_region_select', 'roof_target', 'ceramic_target');
    }

    public function removeDataRegion($type, $key)
    {
        if ($type == 'roof') {
            unset($this->data_roof_region[$key]);
        } elseif ($type == 'ceramic') {
            unset($this->data_ceramic_region[$key]);
        }
    }

    public function generate()
    {
        $request = [
            'date' => $this->generate_month,
            'datas' => [
                'roof' => $this->data_roof_region,
                'ceramic' => $this->data_ceramic_region,
            ]
        ];

        return app(RegionCommissionService::class)->generate($request);
    }
}
