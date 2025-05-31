<table>
    <thead>
        <tr>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 50px;">No</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Nama Sales</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">NIK</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Produk</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Total Penjualan</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Batas Bawah Target</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Status</th>
            <th colspan = "4" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Komisi</th>
        </tr>
        <tr>
            <th style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">JT + 15 Hari</th>
            <th style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">JT+1+ s/d JT+22</th>
            <th style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Hangus</th>
            <th style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Rincian</th>
            <th style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Total</th>
            <th style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Admin 10 %</th>
            <th style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Sales 90 %</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $result)
            @php
                $row_span = 0;
                foreach ($categories as $key => $category) {
                    $row_span += count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1;
                    $total_commission = ($service->commissionSales($result?->id, $categories[0])?->value_commission + $service->commissionSales($result?->id, $categories[1])?->value_commission) + ($service->commissionSales($result?->id, $categories[0])?->add_on_commission + $service->commissionSales($result?->id, $categories[1])?->add_on_commission);
                }
            @endphp
            <tr wire:key='{{ rand() }}'>
                {{-- <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $sales?->currentPage() * $perPage - $perPage + $loop->iteration }}</td> --}}
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $loop->iteration }}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $result?->name ? $result?->name .'-'. $result?->userDetail?->depo : '-' }}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;">{{ $result?->userDetail?->civil_registration_number ? $result?->userDetail?->civil_registration_number : '-' }}</td>
                <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($service->lowerLimiCommissions($result?->id, $categories[0])) : 1 }}" style="border: 1.5px solid black;text-align: center;vertical-align: middle;"><b>All</b></td>
                <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($service->lowerLimiCommissions($result?->id, $categories[0])) : 1 }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($service->commissionSales($result?->id, $categories[0])?->total_sales ?? 0, 0, ',', '.') }}</td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">
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
                <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($service->lowerLimiCommissions($result?->id, $categories[0])) : 1 }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $service->commissionDetail($result?->id, $categories[0], 100)?->value_of_due_date ? "Rp. ". number_format($service->commissionDetail($result?->id, $categories[0], 100)?->value_of_due_date ?? 0, 0, ',', '.') : '-' }}</td>
                <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($service->lowerLimiCommissions($result?->id, $categories[0])) : 1 }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $service->commissionDetail($result?->id, $categories[0], 50)?->value_of_due_date ? "Rp. ". number_format($service->commissionDetail($result?->id, $categories[0], 50)?->value_of_due_date ?? 0, 0, ',', '.') : '-' }}</td>
                <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($service->lowerLimiCommissions($result?->id, $categories[0])) : 1 }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $service->commissionDetail($result?->id, $categories[0], 0)?->value_of_due_date ? "Rp. ". number_format($service->commissionDetail($result?->id, $categories[0], 0)?->value_of_due_date ?? 0, 0, ',', '.') : '-' }}</td>
                <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($service->lowerLimiCommissions($result?->id, $categories[0])) : 1 }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $service->commissionSales($result?->id, $categories[0])?->value_commission ? "Rp. ". number_format($service->commissionSales($result?->id, $categories[0])?->value_commission ?? 0, 0, ',', '.') : '-' }}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $total_commission > 0 ? "Rp. ". number_format($total_commission ?? 0, 0, ',', '.') : '-'}}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $total_commission > 0 ? "Rp. ". number_format($total_commission * 0.1 ?? 0, 0, ',', '.') : '-'}}</td>
                <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $total_commission > 0 ? "Rp. ". number_format($total_commission * 0.9 ?? 0, 0, ',', '.') : '-'}}</td>
            </tr>
            @if (count($service->lowerLimiCommissions($result?->id, $categories[0])) > 0)
                @foreach ($service->lowerLimiCommissions($result?->id, $categories[0]) as $key => $lower_limit_commission)
                    @if ($key > 0)
                        <tr>
                            <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">
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
                        <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1 }}"style="border: 1.5px solid black;text-align: center;vertical-align: middle;"><b>Dr Sonne</b></td>
                        <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1 }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($service->commissionSales($result?->id, $category)?->total_sales ?? 0, 0, ',', '.') }}</td>
                        <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">
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
                        <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1 }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $service->commissionDetail($result?->id, $category, 100)?->value_of_due_date ? "Rp. ". number_format($service->commissionDetail($result?->id, $category, 100)?->value_of_due_date ?? 0, 0, ',', '.') : '-' }}</td>
                        <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1 }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $service->commissionDetail($result?->id, $category, 50)?->value_of_due_date ? "Rp. ". number_format($service->commissionDetail($result?->id, $category, 50)?->value_of_due_date ?? 0, 0, ',', '.') : '-' }}</td>
                        <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1 }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $service->commissionDetail($result?->id, $category, 0)?->value_of_due_date ? "Rp. ". number_format($service->commissionDetail($result?->id, $category, 0)?->value_of_due_date ?? 0, 0, ',', '.') : '-' }}</td>
                        <td rowspan="{{ count($service->lowerLimiCommissions($result?->id, $category)) > 0 ? count($service->lowerLimiCommissions($result?->id, $category)) : 1 }}" style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $service->commissionSales($result?->id, $category)?->value_commission || $service->commissionSales($result?->id, $category)?->add_on_commission ? "Rp. ". number_format($service->commissionSales($result?->id, $category)?->value_commission + $service->commissionSales($result?->id, $category)?->add_on_commission  ?? 0, 0, ',', '.') : '-' }}</td>
                    </tr>
                    @if (count($service->lowerLimiCommissions($result?->id, $category)) > 0)
                        @foreach ($service->lowerLimiCommissions($result?->id, $category) as $key => $lower_limit_commission)
                            @if ($key > 0)
                                <tr>
                                    <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">
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
    </tbody>
</table>