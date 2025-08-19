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
            <th rowspan = "1" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Komisi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $result)
            @php
                $row_span = 0;
                foreach ($categories as $key => $category) {
                    $row_span += count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1;
                }
            @endphp
             <tr wire:key='{{ rand() }}'>
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $loop->iteration }}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $result?->name ? $result?->name .'-'. $result?->userDetail?->depo : '-' }}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $result?->userDetail?->civil_registration_number ? $result?->userDetail?->civil_registration_number : '-' }}</td>
                <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($service->lowerLimiCommissions($result?->id, $categories[0])) : 1 }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;"><b>Dr Shield</b></td>
                <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($service->lowerLimiCommissions($result?->id, $categories[0])) : 1 }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ "Rp. ". number_format($service->commissionSales($result?->id, $categories[0])?->total_sales ?? 0, 0, ',', '.') }}</td>
                <td style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
                    @if (count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0)
                        <div class="d-flex">
                            <div class="p-2">Rp. {{ number_format($service->lowerLimiCommissions($result?->id,  $categories[0])[0]?->target_payment, 0, ',', '.') }}</div>
                            <div class="p-2">({{ $service->lowerLimiCommissions($result?->id, $categories[0])[0]?->value }}%)</div>
                        </div>
                    @else
                        -
                    @endif
                </td>
                <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($service->lowerLimiCommissions($result?->id, $categories[0])) : 1 }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
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
                <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($service->lowerLimiCommissions($result?->id, $categories[0])) : 1 }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $service->commissionSales($result?->id, $categories[0])?->value_commission ? "Rp. ". number_format($service->commissionSales($result?->id, $categories[0])?->value_commission ?? 0, 0, ',', '.') : '-' }}</td>
            </tr>
            @if (count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0)
                @foreach ($service->lowerLimiCommissions($result?->id, $categories[0]) as $key => $lower_limit_commission)
                    @if ($key > 0)
                        <tr>
                            <td style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
                                <div class="d-flex">
                                    <div class="p-2">Rp. {{ number_format($lower_limit_commission?->target_payment, 0, ',', '.') }}</div>
                                    <div class="p-2">({{ $lower_limit_commission?->value }}%)</div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
            @if (count($categories) > 0)
                @foreach ($categories as $key => $category)
                    @if ($key == 0 )
                        @continue
                    @endif
                    <tr>
                        <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1 }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;"><b>{{ $category?->name }}</b></td>
                        <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1 }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ "Rp. ". number_format($service->commissionSales($result?->id, $category)?->total_sales ?? 0, 0, ',', '.') }}</td>
                        <td style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
                            @if (count($service->lowerLimiCommissions($result?->id, $category)) > 0)
                                <div class="d-flex">
                                    <div class="p-2">Rp. {{ number_format($service->lowerLimiCommissions($result?->id, $category)[0]?->target_payment, 0, ',', '.') }}</div>
                                    <div class="p-2">({{ $service->lowerLimiCommissions($result?->id, $category)[0]?->value }}%)</div>
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1 }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
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
                        <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1 }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $service->commissionSales($result?->id, $category)?->value_commission ? "Rp. ". number_format($service->commissionSales($result?->id, $category)?->value_commission ?? 0, 0, ',', '.') : '-' }}</td>
                    </tr>
                    @if (count($service->lowerLimiCommissions($result?->id, $category)) > 0)
                        @foreach ($service->lowerLimiCommissions($result?->id, $category) as $key => $lower_limit_commission)
                            @if ($key > 0)
                                <tr>
                                    <td style="border: 1.5px solid black;text-align: center;vertical-align: middle;">
                                        <div class="d-flex">
                                            <div class="p-2">Rp. {{ number_format($lower_limit_commission?->target_payment, 0, ',', '.') }}</div>
                                            <div class="p-2">({{ $lower_limit_commission?->value }}%)</div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="2" style="text-align: center; vertical-align: middle">Dibuat Oleh,</td>
            <td colspan="4" style="text-align: center; vertical-align: middle">Mengetahui,</td>
            <td colspan="2" style="text-align: center; vertical-align: middle">Menyetujui,</td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="2" style="text-align: center; vertical-align: middle">Admin</td>
            <td colspan="2" style="text-align: center; vertical-align: middle">RM 1</td>
            <td colspan="2" style="text-align: center; vertical-align: middle">RM 2</td>
            <td colspan="1" style="text-align: center; vertical-align: middle">NOM</td>
            <td colspan="1" style="text-align: center; vertical-align: middle">Direktur ABC</td>
        </tr>
    </tbody>
</table>
