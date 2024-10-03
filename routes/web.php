<?php

use App\Livewire\Auth\AuthLogin\AuthLoginIndex;
use App\Livewire\Sales\SalesList;
use App\Livewire\Sales\SalesList\SalesListIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return redirect()->route('auth.login');
});

Route::get('/login', AuthLoginIndex::class)->name('auth.login');

Route::prefix('/sales')->group(function () {
    Route::get('/daftar', SalesListIndex::class)->name('sales.list');
});
