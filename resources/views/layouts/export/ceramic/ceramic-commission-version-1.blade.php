@php
    use Carbon\Carbon;
@endphp
<table>
    <thead>
        <tr>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 50px;">No</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 200px;">Nama Sales</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 100px;">NIK</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 50px;">DEPO</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Total Penjualan</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Batas Bawah Target</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Status</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Bulan Bayar</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Bayar Ontime</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">0 - 7 Hari dari JT</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Hangus</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Total Uang Masuk</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Komisi</th>
            <th style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Admin 10 %</th>
            <th style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Sales 90 %</th>
            {{-- <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Total</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $result)
            @php
                $row_span = 4; $total_commission = 0;
                $column_detail = 4;
            @endphp
             <tr wire:key='{{ rand() }}'>
                <td rowspan="{{ $row_span > 0 ? $row_span : $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $loop->iteration }}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $result?->name ?? '-' }}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $result?->userDetail?->civil_registration_number ? $result?->userDetail?->civil_registration_number : '-' }}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $result?->userDetail?->depo ?? '-' }}</td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ "Rp. ". number_format($service->commissionSales($result?->id)?->total_sales ?? 0, 0, ',', '.') }}</td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
                    @if (count($service->lowerLimiCommissions($result?->id)) > 0)
                        @foreach ($service->lowerLimiCommissions($result?->id) as $key => $lower_limit_commission)
                            Rp. {{ number_format($lower_limit_commission?->target_payment, 0, ',', '.') }}
                            ({{ $lower_limit_commission?->value }}%) <br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
                    @if ($service->commissionSales($result?->id) != null)
                        @if ($service->commissionSales($result?->id)?->status == 'reached')
                            <span class="badge rounded-pill bg-success bg-glow">Mencapai Target</span>
                        @else
                            <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                        @endif
                    @else
                        <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                    @endif
                </td>
                {{-- @dd($service->getTime($result?->id)[0]['year'], $service->getTime($result?->id)[0]['month'], 100) --}}
                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id)[0]) ? Carbon::createFromFormat('m', $service->getTime($result?->id)[0]['month'])->translatedFormat('F') : '-' }}</td>
                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id)[0]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $service->getTime($result?->id)[0]['year'], $service->getTime($result?->id)[0]['month'], 100)?->total_income, 0, ',', '.') : '-' }}</td>
                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id)[0]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $service->getTime($result?->id)[0]['year'], $service->getTime($result?->id)[0]['month'], 50)?->total_income, 0, ',', '.') : '-' }}</td>
                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id)[0]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $service->getTime($result?->id)[0]['year'], $service->getTime($result?->id)[0]['month'], 0)?->total_income, 0, ',', '.') : '-' }}</td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $service->getTotalIncome($result?->id, null, null, 100) + $service->getTotalIncome($result?->id, null, null, 50) > 0 ? "Rp. ". number_format($service->getTotalIncome($result?->id, null, null, 100) + $service->getTotalIncome($result?->id, null, null, 50), 0, ',', '.') : '-' }}</td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $service->commissionSales($result?->id)?->value_commission ? "Rp. ". number_format($service->commissionSales($result?->id)?->value_commission ?? 0, 0, ',', '.') : '-' }}</td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $service->commissionSales($result?->id)?->value_commission ? "Rp. ". number_format($service->commissionSales($result?->id)?->value_commission * (10/100) ?? 0, 0, ',', '.') : '-' }}</td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $service->commissionSales($result?->id)?->value_commission ? "Rp. ". number_format($service->commissionSales($result?->id)?->value_commission * (90/100) ?? 0, 0, ',', '.') : '-' }}</td>
                {{-- <td rowspan="{{ $row_span }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ "Rp ". number_format($total_commission, 0, ',', '.') }}</td> --}}
            </tr>
            @for ($i = 0; $i < $column_detail; $i++)
                @if ($i > 0)
                    <tr>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id)[$i]) ? Carbon::createFromFormat('m', $service->getTime($result?->id)[$i]['month'])->translatedFormat('F') : '-' }}</td>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id)[$i]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $service->getTime($result?->id)[$i]['year'], $service->getTime($result?->id)[$i]['month'], 100)?->total_income, 0, ',', '.') : '-' }}</td>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id)[$i]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $service->getTime($result?->id)[$i]['year'], $service->getTime($result?->id)[$i]['month'], 50)?->total_income, 0, ',', '.') : '-' }}</td>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id)[$i]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $service->getTime($result?->id)[$i]['year'], $service->getTime($result?->id)[$i]['month'], 0)?->total_income, 0, ',', '.') : '-' }}</td>
                    </tr>
                @endif
            @endfor
        @endforeach
        <tr></tr>
        <tr></tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: center; vertical-align: middle">Dibuat Oleh,</td>
            <td colspan="4" style="text-align: center; vertical-align: middle">Mengetahui,</td>
            <td colspan="2" style="text-align: center; vertical-align: middle">Menyetujui,</td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: center; vertical-align: middle">Admin</td>
            <td colspan="2" style="text-align: center; vertical-align: middle">RM 1</td>
            <td colspan="2" style="text-align: center; vertical-align: middle">RM 2</td>
            <td colspan="1" style="text-align: center; vertical-align: middle">NOM</td>
            <td colspan="1" style="text-align: center; vertical-align: middle">Direktur ABC</td>
        </tr>
    </tbody>
</table>
