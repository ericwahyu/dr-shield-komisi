@php
    use Carbon\Carbon;
@endphp
<table>
    <thead>
        <tr>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 50px;">No</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 200px;">Nama Sales</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">NIK</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Produk</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Total Penjualan</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Batas Bawah Target</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Status</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Bulan Bayar</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Bayar Ontime</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">0 - 7 Hari dari JT</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Hangus</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Total Uang Masuk</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Komisi</th>
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $result)
            @php
                $row_span = 0; $total_commission = 0;
                $col_detail  = 4;
                foreach ($categories as $key => $category) {
                    $row_span += $col_detail;
                    $total_commission += (int)$service->commissionSales($result?->id, $category)?->value_commission;
                }
                $column_detail = 4;
            @endphp
             <tr wire:key='{{ rand() }}'>
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $loop->iteration }}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $result?->name ? $result?->name .'-'. $result?->userDetail?->depo : '-' }}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $result?->userDetail?->civil_registration_number ? $result?->userDetail?->civil_registration_number : '-' }}</td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;"><b>{{ $categories[0]?->name }}</b></td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ "Rp. ". number_format($service->commissionSales($result?->id, $categories[0])?->total_sales ?? 0, 0, ',', '.') }}</td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
                    @if (count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0)
                        @foreach ($service->lowerLimiCommissions($result?->id, $categories[0]) as $key => $lower_limit_commission)
                            Rp. {{ number_format($lower_limit_commission?->target_payment, 0, ',', '.') }}
                            ({{ $lower_limit_commission?->value }}%) <br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
                    @if ($service->commissionSales($result?->id, $categories[0]) != null)
                        @if ($service->commissionSales($result?->id, $categories[0])?->status == 'reached')
                            <span class="badge rounded-pill bg-success bg-glow">Mencapai Target</span>
                        @else
                            <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                        @endif
                    @else
                        <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                    @endif
                </td>
                {{-- @dd($service->getTime($result?->id, $categories[0])[0]['year'], $service->getTime($result?->id, $categories[0])[0]['month'], 100) --}}
                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $categories[0])[0]) ? Carbon::createFromFormat('m', $service->getTime($result?->id, $categories[0])[0]['month'])->translatedFormat('F') : '-' }}</td>
                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $categories[0])[0]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $categories[0], $service->getTime($result?->id, $categories[0])[0]['year'], $service->getTime($result?->id, $categories[0])[0]['month'], 100)?->total_income, 0, ',', '.') : '-' }}</td>
                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $categories[0])[0]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $categories[0], $service->getTime($result?->id, $categories[0])[0]['year'], $service->getTime($result?->id, $categories[0])[0]['month'], 50)?->total_income, 0, ',', '.') : '-' }}</td>
                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $categories[0])[0]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $categories[0], $service->getTime($result?->id, $categories[0])[0]['year'], $service->getTime($result?->id, $categories[0])[0]['month'], 0)?->total_income, 0, ',', '.') : '-' }}</td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $service->getTotalIncome($result?->id, $categories[0], null, null, 100) + $service->getTotalIncome($result?->id, $categories[0], null, null, 50) > 0 ? "Rp. ". number_format($service->getTotalIncome($result?->id, $categories[0], null, null, 100) + $service->getTotalIncome($result?->id, $categories[0], null, null, 50), 0, ',', '.') : '-' }}</td>
                <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $service->commissionSales($result?->id, $categories[0])?->value_commission ? "Rp. ". number_format($service->commissionSales($result?->id, $categories[0])?->value_commission ?? 0, 0, ',', '.') : '-' }}</td>
                <td rowspan="{{ $row_span }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ "Rp ". number_format($total_commission, 0, ',', '.') }}</td>
            </tr>
            @for ($i = 0; $i < $column_detail; $i++)
                @if ($i > 0)
                    <tr>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $categories[0])[$i]) ? Carbon::createFromFormat('m', $service->getTime($result?->id, $categories[0])[$i]['month'])->translatedFormat('F') : '-' }}</td>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $categories[0])[$i]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $categories[0], $service->getTime($result?->id, $categories[0])[$i]['year'], $service->getTime($result?->id, $categories[0])[$i]['month'], 100)?->total_income, 0, ',', '.') : '-' }}</td>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $categories[0])[$i]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $categories[0], $service->getTime($result?->id, $categories[0])[$i]['year'], $service->getTime($result?->id, $categories[0])[$i]['month'], 50)?->total_income, 0, ',', '.') : '-' }}</td>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $categories[0])[$i]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $categories[0], $service->getTime($result?->id, $categories[0])[$i]['year'], $service->getTime($result?->id, $categories[0])[$i]['month'], 0)?->total_income, 0, ',', '.') : '-' }}</td>
                    </tr>
                @endif
            @endfor

            @if (count($categories) > 0)
                @foreach ($categories as $key => $category)
                    @if ($key == 0 )
                        @continue
                    @endif
                    <tr>
                        <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;"><b>{{ $category?->name }}</b></td>
                        <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ "Rp. ". number_format($service->commissionSales($result?->id, $category)?->total_sales ?? 0, 0, ',', '.') }}</td>
                        <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
                            @if (count($service->lowerLimiCommissions($result?->id, $category)) > 0)
                                @foreach ($service->lowerLimiCommissions($result?->id, $category) as $key => $lower_limit_commission)
                                    Rp. {{ number_format($lower_limit_commission?->target_payment, 0, ',', '.') }}
                                    ({{ $lower_limit_commission?->value }}%) <br>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                        <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
                            @if ($service->commissionSales($result?->id, $category) != null)
                                @if ($service->commissionSales($result?->id, $category)?->status == 'reached')
                                    <span class="badge rounded-pill bg-success bg-glow">Mencapai Target</span>
                                @else
                                    <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                                @endif
                            @else
                                <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                            @endif
                        </td>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $category)[0]) ? Carbon::createFromFormat('m', $service->getTime($result?->id, $category)[0]['month'])->translatedFormat('F') : '-' }}</td>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $category)[0]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $category, $service->getTime($result?->id, $category)[0]['year'], $service->getTime($result?->id, $category)[0]['month'], 100)?->total_income, 0, ',', '.') : '-' }}</td>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $category)[0]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $category, $service->getTime($result?->id, $category)[0]['year'], $service->getTime($result?->id, $category)[0]['month'], 50)?->total_income, 0, ',', '.') : '-' }}</td>
                        <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $category)[0]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $category, $service->getTime($result?->id, $category)[0]['year'], $service->getTime($result?->id, $category)[0]['month'], 0)?->total_income, 0, ',', '.') : '-' }}</td>
                        <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $service->getTotalIncome($result?->id, $category, null, null, 100) + $service->getTotalIncome($result?->id, $category, null, null, 50) > 0 ? "Rp. ". number_format($service->getTotalIncome($result?->id, $category, null, null, 100) + $service->getTotalIncome($result?->id, $category, null, null, 50), 0, ',', '.') : '-' }}</td>
                        <td rowspan="{{ $column_detail }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $service->commissionSales($result?->id, $category)?->value_commission ? "Rp. ". number_format($service->commissionSales($result?->id, $category)?->value_commission ?? 0, 0, ',', '.') : '-' }}</td>
                    </tr>
                    @for ($i = 0; $i < $column_detail; $i++)
                        @if ($i > 0)
                            <tr>
                                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $category)[$i]) ? Carbon::createFromFormat('m', $service->getTime($result?->id, $category)[$i]['month'])->translatedFormat('F') : '-' }}</td>
                                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $category)[$i]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $category, $service->getTime($result?->id, $category)[$i]['year'], $service->getTime($result?->id, $category)[$i]['month'], 100)?->total_income, 0, ',', '.') : '-' }}</td>
                                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $category)[$i]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $category, $service->getTime($result?->id, $category)[$i]['year'], $service->getTime($result?->id, $category)[$i]['month'], 50)?->total_income, 0, ',', '.') : '-' }}</td>
                                <td rowspan="1" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ isset($service->getTime($result?->id, $category)[$i]) ? "Rp. ". number_format($service->getDetailCommission($result?->id, $category, $service->getTime($result?->id, $category)[$i]['year'], $service->getTime($result?->id, $category)[$i]['month'], 0)?->total_income, 0, ',', '.') : '-' }}</td>
                            </tr>
                        @endif
                    @endfor
                @endforeach
            @endif
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
