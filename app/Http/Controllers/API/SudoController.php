<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Commission\Commission;
use App\Models\Commission\CommissionDetail;
use App\Models\Commission\LowerLimitCommission;
use App\Models\Invoice\DueDateRule;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceDetail;
use App\Models\Invoice\PaymentDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class SudoController extends BaseController
{
    //
    public function forcoDelete(Request $request)
    {
        $rules = [
            'month'    => ['required'],
            'sales_id' => ['nullable'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError('Input tidak sesuai dengan ketentuan.', $validator->errors(), 400);
        }

        try {
            DB::beginTransaction();
                $invoice_ids = Invoice::whereYear('date', Carbon::parse($request?->month)->year)->whereMonth('date', Carbon::parse($request?->month)->month)->when($request->sales_id != null, function ($query) use ($request) {
                    $query->where('user_id', $request->sales_id);
                })->pluck('id')->toArray();
                InvoiceDetail::whereIn('invoice_id', $invoice_ids)->forceDelete();
                PaymentDetail::whereIn('invoice_id', $invoice_ids)->forceDelete();
                DueDateRule::whereIn('invoice_id', $invoice_ids)->forceDelete();

                $commission_ids = Commission::where('year', Carbon::parse($request?->month)->year)->where('month', Carbon::parse($request?->month)->month)->when($request->sales_id != null, function ($query) use ($request)  {
                    $query->where('user_id', $request->sales_id);
                })->pluck('id')->toArray();
                LowerLimitCommission::whereIn('commission_id', $commission_ids)->forceDelete();
                CommissionDetail::whereIn('commission_id', $commission_ids)->forceDelete();

                InvoiceDetail::whereYear('date', Carbon::parse($request?->month)->year)->whereMonth('date', Carbon::parse($request?->month)->month)->when($request?->sales_id != null, function ($query) use ($request) {
                    $query->whereHas('invoice.user', function ($query) use ($request) {
                        $query->where('user_id', $request?->sales_id);
                    });
                })->forceDelete();
                Invoice::whereYear('date', Carbon::parse($request?->month)->year)->whereMonth('date', Carbon::parse($request?->month)->month)->when($request->sales_id != null, function ($query) use ($request)  {
                    $query->where('user_id', $request->sales_id);
                })->forceDelete();
                Commission::where('year', Carbon::parse($request?->month)->year)->where('month', Carbon::parse($request?->month)->month)->when($request->sales_id != null, function ($query) use ($request)  {
                    $query->where('user_id', $request->sales_id);
                })->forceDelete();


                // InvoiceDetail::whereDate('created_at', $request?->created_at)->forceDelete();
                // PaymentDetail::whereDate('created_at', $request?->created_at)->forceDelete();
                // DueDateRule::whereDate('created_at', $request?->created_at)->forceDelete();

                // LowerLimitCommission::whereDate('created_at', $request?->created_at)->forceDelete();
                // CommissionDetail::whereDate('created_at', $request?->created_at)->forceDelete();


            DB::commit();
        } catch (Exception | Throwable $th) {
            DB::rollBack();
            $error = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            return $this->sendError("Ada kealahan saat forceDelete" , $error);
        }
    }
}
