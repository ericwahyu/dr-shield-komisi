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
            'created_at' => ['required', 'date'],
            'user_id'    => ['nullable'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError('Input tidak sesuai dengan ketentuan.', $validator->errors(), 400);
        }

        try {
            DB::beginTransaction();

                $invoice_ids = Invoice::whereDate('created_at', $request?->created_at)->pluck('id')->toArray();
                InvoiceDetail::whereIn('invoice_id', $invoice_ids)->forcoDelete();
                PaymentDetail::whereIn('invoice_id', $invoice_ids)->forcoDelete();
                DueDateRule::whereIn('invoice_id', $invoice_ids)->forcoDelete();

                $commission_ids = Commission::whereDate('created_at', $request?->created_at)->pluck('id')->toArray();
                LowerLimitCommission::whereIn('commission_id', $commission_ids)->forcoDelete();
                CommissionDetail::whereIn('commission_id', $commission_ids)->forcoDelete();

                Invoice::whereDate('created_at', $request?->created_at)->forcoDelete();
                Commission::whereDate('created_at', $request?->created_at)->forcoDelete();

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
