@section('title', 'Detail Komisi Wilayah')
<div>
    {{-- Do your work, then step back. --}}
     <div class="d-flex align-items-center">
        <a href="{{ route('region.commission') }}" class="btn btn-icon" style="margin-right: 15px"><i class="fa-solid fa-arrow-left"></i></a>
        <div>
            <h3 class="mb-0 fw-semibold">Detail Komisi Wilayah <b>{{ $month->format('F Y') }}</b></h3>
        </div>
        <div class="ms-auto">
            {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-export">Tambah <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></button> --}}
            {{-- <a href="{{ route('region.commission') }}" class="btn btn-success" >Tambah <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></a> --}}
        </div>
    </div>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-4 card">
                <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="text-align: center">Perhitungan Komisi BM/SPV Atap </h5>
                    </div>
                <div class="table-responsive scrollbar-x">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" class="text-center">Depo</th>
                                <th rowspan="2" class="text-center">BM/SPV</th>
                                <th rowspan="2" class="text-center">NIK</th>
                                @foreach ($target_percentage as $target_percentage_1)
                                    <th rowspan="2" class="text-center">Target {{ $target_percentage_1 }}%</th>
                                @endforeach
                                <th rowspan="2" class="text-center">Pencapaian</th>
                                <th colspan="{{ count($payment_percentage) }}" class="text-center">Pembayaran</th>
                                <th rowspan="2" class="text-center">Komisi</th>
                                <th rowspan="2" class="text-center">BM/SPV 80%</th>
                                <th rowspan="2" class="text-center">BM 10%</th>
                                <th rowspan="2" class="text-center">Team 10%</th>
                            </tr>
                            <tr>
                                @foreach ($payment_percentage as $payment_percentage_1)
                                    <th class="text-center">{{ $payment_percentage_1 }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $key => $result)
                                <tr>
                                    <td class="text-center">{{ $result?->depo }}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    @php
                                        $targets = json_decode($result->targets, true);
                                        krsort($targets);
                                    @endphp
                                    @foreach ($target_percentage as $target_percentage_2)
                                        {{-- @dd() --}}
                                        <td class="text-center">{{ isset($targets[$target_percentage_2]) ? "Rp. ". number_format($targets[$target_percentage_2], 0, ',', '.') : '-' }}</td>
                                    @endforeach
                                    <td class="text-center">{{ $result?->percentage_target ? $result?->percentage_target."%" : 'Tidak Mencapai' }}</td>
                                    @php
                                        $payments = json_decode($result->payments, true);
                                        $totalCommission = 0;
                                    @endphp
                                    @foreach ($payment_percentage as $key => $payment_percentage_2)
                                        <td class="text-center">{{ isset($payments[$key]['total_amount']) ? "Rp. ". number_format($payments[$key]['total_amount'], 0, ',', '.') : '-' }}</td>
                                        @php
                                            $totalCommission += $payments[$key]['commission'] ?? 0;
                                        @endphp
                                    @endforeach
                                    <td class="text-center">{{ "Rp. ". number_format($totalCommission, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ "Rp. ". number_format($totalCommission * (80/100), 0, ',', '.') }}</td>
                                    <td class="text-center">{{ "Rp. ". number_format($totalCommission * (10/100), 0, ',', '.') }}</td>
                                    <td class="text-center">{{ "Rp. ". number_format($totalCommission * (10/100), 0, ',', '.') }}</td>
                                </tr>
                                {{-- <td class="text-center">{{ $key }}</td>
                                <td class="text-center">
                                    <a href="{{ route('region.commission-detail', "$key") }}" class="btn btn-info btn-sm" x-data="{ tooltip: 'Lihat Detail' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info fa-fw"></i></a>
                                </td> --}}
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center fw-bold">Belum Ada Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-4 card">
                <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="text-align: center">Perhitungan Komisi BM/SPV Atap </h5>
                    </div>
                <div class="table-responsive scrollbar-x">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" class="text-center">Depo</th>
                                <th rowspan="2" class="text-center">BM/SPV</th>
                                <th rowspan="2" class="text-center">NIK</th>
                                @foreach ($target_percentage as $target_percentage_1)
                                    <th rowspan="2" class="text-center">Target {{ $target_percentage_1 }}%</th>
                                @endforeach
                                <th rowspan="2" class="text-center">Pencapaian</th>
                                <th colspan="{{ count($payment_percentage) }}" class="text-center">Pembayaran</th>
                                <th rowspan="2" class="text-center">Komisi</th>
                                <th rowspan="2" class="text-center">BM/SPV 80%</th>
                                <th rowspan="2" class="text-center">BM 10%</th>
                                <th rowspan="2" class="text-center">Team 10%</th>
                            </tr>
                            <tr>
                                @foreach ($payment_percentage as $payment_percentage_1)
                                    <th class="text-center">{{ $payment_percentage_1 }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $key => $result)
                                <tr>
                                    <td class="text-center">{{ $result?->depo }}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    @php
                                        $targets = json_decode($result->targets, true);
                                        krsort($targets);
                                    @endphp
                                    @foreach ($target_percentage as $target_percentage_2)
                                        {{-- @dd() --}}
                                        <td class="text-center">{{ isset($targets[$target_percentage_2]) ? "Rp. ". number_format($targets[$target_percentage_2], 0, ',', '.') : '-' }}</td>
                                    @endforeach
                                    <td class="text-center">{{ $result?->percentage_target ? $result?->percentage_target."%" : 'Tidak Mencapai' }}</td>
                                    @php
                                        $payments = json_decode($result->payments, true);
                                        $totalCommission = 0;
                                    @endphp
                                    @foreach ($payment_percentage as $key => $payment_percentage_2)
                                        <td class="text-center">{{ isset($payments[$key]['total_amount']) ? "Rp. ". number_format($payments[$key]['total_amount'], 0, ',', '.') : '-' }}</td>
                                        @php
                                            $totalCommission += $payments[$key]['commission'] ?? 0;
                                        @endphp
                                    @endforeach
                                    <td class="text-center">{{ "Rp. ". number_format($totalCommission, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ "Rp. ". number_format($totalCommission * (80/100), 0, ',', '.') }}</td>
                                    <td class="text-center">{{ "Rp. ". number_format($totalCommission * (10/100), 0, ',', '.') }}</td>
                                    <td class="text-center">{{ "Rp. ". number_format($totalCommission * (10/100), 0, ',', '.') }}</td>
                                </tr>
                                {{-- <td class="text-center">{{ $key }}</td>
                                <td class="text-center">
                                    <a href="{{ route('region.commission-detail', "$key") }}" class="btn btn-info btn-sm" x-data="{ tooltip: 'Lihat Detail' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info fa-fw"></i></a>
                                </td> --}}
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center fw-bold">Belum Ada Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
