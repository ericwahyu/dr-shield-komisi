<?php

use App\Livewire\Auth\AuthLogin\AuthLoginIndex;
use App\Livewire\Commission\ActualTarget\ActualTargetIndex;
use App\Livewire\Commission\CeramicCommission\CeramicCommissionDetail;
use App\Livewire\Commission\CeramicCommission\CeramicCommissionIndex;
use App\Livewire\Commission\CeramicCommission\CeramicCommissionV2\CeramicCommissionDetailV2;
use App\Livewire\Commission\RoofCommission\RoofCommissionDetail;
use App\Livewire\Commission\RoofCommission\RoofCommissionIndex;
use App\Livewire\Commission\RoofCommission\RoofCommissionV2\RoofCommissionDetailV2;
use App\Livewire\Invoice\CeramicInvoice\CeramicInvoiceDetail;
use App\Livewire\Invoice\CeramicInvoice\CeramicInvoiceIndex;
use App\Livewire\Invoice\RoofInvoice\RoofInvoiceDetail;
use App\Livewire\Invoice\RoofInvoice\RoofInvoiceIndex;
use App\Livewire\Sales\SalesList;
use App\Livewire\Sales\SalesList\SalesListIndex;
use App\Livewire\Sales\SalesList\SalesLowerLimit\SalesLowerLimitIndex;
use App\Livewire\Setting\ResetFaktur\ResetFakturIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function (){
    return redirect()->route('login');
});

Route::get('/login', AuthLoginIndex::class)->name('login');

Route::get('/logout', function () {
    Session::flush();
    Auth::logout();
    return redirect()->to('/');
});

Route::middleware('auth')->group(function () {
    Route::prefix('/sales')->group(function () {
        Route::get('/daftar', SalesListIndex::class)->name('sales.list');
        Route::get('/batas-bawah-target/{id}', SalesLowerLimitIndex::class)->name('sales.lower.limit');
    });

    Route::prefix('/faktur')->group(function () {
        Route::get('/keramik', CeramicInvoiceIndex::class)->name('ceramic.invoice');
        Route::get('/keramik-detail/{id}', CeramicInvoiceDetail::class)->name('ceramic.invoice.detail');

        Route::get('/atap', RoofInvoiceIndex::class)->name('roof.invoice');
        Route::get('/atap-detail/{id}', RoofInvoiceDetail::class)->name('roof.invoice.detail');
    });

    Route::prefix('/komisi')->group(function () {
        Route::get('/target-aktual', ActualTargetIndex::class)->name('actual.target.commission');

        Route::get('/keramik', CeramicCommissionIndex::class)->name('ceramic.commission');
        Route::get('/keramik-detail/{sales_id}/{month_commission}/1', CeramicCommissionDetail::class)->name('ceramic.commission.detail.v1');
        Route::get('/keramik-detail/{sales_id}/{month_commission}/2', CeramicCommissionDetailV2::class)->name('ceramic.commission.detail.v2');

        Route::get('/atap', RoofCommissionIndex::class)->name('roof.commission');
        Route::get('/atap-detail/{sales_id}/{month_commission}/{category}/1', RoofCommissionDetail::class)->name('roof.commission.detail.v1');
        Route::get('/atap-detail/{sales_id}/{month_commission}/{category}/2', RoofCommissionDetailV2::class)->name('roof.commission.detail.v2');
    });

    Route::prefix('/pengaturan')->group(function () {
        Route::get('/reset-data-faktur', ResetFakturIndex::class)->name('factur-reset');
    });
});

