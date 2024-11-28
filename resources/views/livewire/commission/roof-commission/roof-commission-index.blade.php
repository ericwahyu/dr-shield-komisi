@section('title', 'Komisi Atap')
<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="d-flex align-items-center">
        <div>
            <h3 class="mb-0 fw-semibold">Komisi Atap</h3>
        </div>
        <div class="ms-auto">
            {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">Tambah <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></button> --}}
        </div>
    </div>
    <hr class="my-3">
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between g-3">
                <div class="col-12 col-lg-4">
                    <div class="row">
                        <div class="gap-2 col-lg-6 col-12 d-flex align-items-center">
                            <div>Lihat</div>
                            <select class="form-select" wire:model.live="perPage">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <div class="ms-auto">Hasil</div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-12 col-lg-2">
                    <div class="row">
                        <div class="gap-2 col-lg-10 col-12 d-flex align-items-center">
                            <select class="form-select" id="" wire:model.live="selectYear" aria-label="Default select example">
                                <option value=""selected style="display: none">-- Pilih Tahun --</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ $year == $selectYear ? "selected" : "" }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-2">
                    <div class="row">
                        <div class="gap-2 col-lg-10 col-12 d-flex align-items-center">
                            <select class="form-select" id="" wire:model.live="selectMonth" aria-label="Default select example">
                                <option value=""selected style="display: none">-- Pilih Bulan --</option>
                                @foreach ($months as $month)
                                    <option value="{{ $month }}" {{ $month == $selectMonth ? "selected" : "" }}>{{ $this->convertNumberToMonth($month) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div> --}}
                <div class="col-12 col-lg-3">
                    <div class="row">
                        <div class="gap-2 col-lg-10 col-12 d-flex align-items-center">
                            <input class="form-control" type="month" wire:model.live="filter_month" id="html5-date-input">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3 text-end">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-regular fa-magnifying-glass fa-fw"></i></span>
                        <input class="form-control" type="text" placeholder="Cari Sesuatu.." wire:model.live="search">
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive scrollbar-x">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 10px;">No</th>
                        <th class="text-center">Nama Sales</th>
                        <th class="text-center">NIK</th>
                        <th class="text-center">Produk</th>
                        <th class="text-center">Total Penjualan</th>
                        <th class="text-center">Batas Bawah Target</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Komisi</th>
                        <th class="text-center" style="width: 10px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $result)
                        @php
                            $lower_limit_shield_commissions = $this->lowerLimiCommissions($result?->id, 'dr-shield');
                            $lower_limit_sonne_commissions  = $this->lowerLimiCommissions($result?->id, 'dr-sonne');
                            $row_span                       = count($lower_limit_shield_commissions) + count($lower_limit_sonne_commissions)
                        @endphp
                        <tr wire:key='{{ rand() }}'>
                            <td rowspan="{{ $row_span > 0 ? $row_span : 2 }}" class="text-center">{{ $sales?->currentPage() * $perPage - $perPage + $loop->iteration }}</td>
                            <td rowspan="{{ $row_span > 0 ? $row_span : 2 }}" class="sorting_1">
                                <div class="d-flex justify-content-start align-items-center product-name">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-nowrap mb-0">{{ $result?->name ? $result?->name : '-' }}</h6>
                                        <small class="text-truncate d-none d-sm-block">{{ $result?->userDetail?->sales_code ? $result?->userDetail?->sales_code : '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td rowspan="{{ $row_span > 0 ? $row_span : 2 }}" class="text-center">{{ $result?->userDetail?->civil_registration_number ? $result?->userDetail?->civil_registration_number : '-' }}</td>
                            <td rowspan="{{ count($lower_limit_shield_commissions) > 0 ? count($lower_limit_shield_commissions) : '' }}" class="text-center"><b>Dr Shield</b></td>
                            <td rowspan="{{ count($lower_limit_shield_commissions) > 0 ? count($lower_limit_shield_commissions) : '' }}" class="text-center">{{ "Rp. ". number_format($this->commissionSales($result?->id, 'dr-shield')?->total_sales ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if (count($lower_limit_shield_commissions) > 0)
                                    <div class="d-flex">
                                        <div class="p-2">Rp. {{ number_format($this->lowerLimiCommissions($result?->id, 'dr-shield')[0]?->target_payment, 0, ',', '.') }}</div>
                                        <div class="p-2">({{ $this->lowerLimiCommissions($result?->id, 'dr-shield')[0]?->value }}%)</div>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td rowspan="{{ count($lower_limit_shield_commissions) > 0 ? count($lower_limit_shield_commissions) : '' }}" class="text-center">
                                @if ($this->commissionSales($result?->id, 'dr-shield') != null)
                                    @if ($this->commissionSales($result?->id, 'dr-shield')?->status == 'reached')
                                        <span class="badge rounded-pill bg-success bg-glow">Mencapai Target</span>
                                    @else
                                        <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                                    @endif
                                @else
                                    <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                                @endif
                            </td>
                            <td rowspan="{{ count($lower_limit_shield_commissions) > 0 ? count($lower_limit_shield_commissions) : '' }}" class="text-center">-</td>
                            <td rowspan="{{ count($lower_limit_shield_commissions) > 0 ? count($lower_limit_shield_commissions) : '' }}" class="text-center">
                                <a class="btn {{ ($this->commissionSales($result?->id, 'dr-shield')?->total_sales ?? 0) > 0 ? "btn-info" : "btn-secondary" }} btn-sm" style="{{ ($this->commissionSales($result?->id, 'dr-shield')?->total_sales ?? 0) < 1 ? "pointer-events: none;" : "" }}" href="{{ route('roof.commission.detail', [$result?->id, $filter_month, 'dr-shield']) }}" x-data="{ tooltip: 'Detail Komisi' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info fa-fw"></i></a>
                            </td>
                        </tr>
                        @if (count($lower_limit_shield_commissions) > 0)
                            @foreach ($lower_limit_shield_commissions as $key => $lower_limit_commission)
                                @if ($key > 0)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex">
                                                <div class="p-2">Rp. {{ number_format($lower_limit_commission?->target_payment, 0, ',', '.') }}</div>
                                                <div class="p-2">({{ $lower_limit_commission?->value }}%)</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        <tr>
                            <td rowspan="{{ count($lower_limit_sonne_commissions) > 0 ? count($lower_limit_sonne_commissions) : '' }}"class="text-center"><b>Dr Sonne</b></td>
                            <td rowspan="{{ count($lower_limit_sonne_commissions) > 0 ? count($lower_limit_sonne_commissions) : '' }}" class="text-center">{{ "Rp. ". number_format($this->commissionSales($result?->id, 'dr-sonne')?->total_sales ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if (count($lower_limit_sonne_commissions) > 0)
                                    <div class="d-flex">
                                        <div class="p-2">Rp. {{ number_format($this->lowerLimiCommissions($result?->id, 'dr-shield')[0]?->target_payment, 0, ',', '.') }}</div>
                                        <div class="p-2">({{ $this->lowerLimiCommissions($result?->id, 'dr-shield')[0]?->value }}%)</div>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td rowspan="{{ count($lower_limit_sonne_commissions) > 0 ? count($lower_limit_sonne_commissions) : '' }}" class="text-center">
                                @if ($this->commissionSales($result?->id, 'dr-sonne') != null)
                                    @if ($this->commissionSales($result?->id, 'dr-sonne')?->status == 'reached')
                                        <span class="badge rounded-pill bg-success bg-glow">Mencapai Target</span>
                                    @else
                                        <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                                    @endif
                                @else
                                    <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                                @endif
                            </td>
                            <td rowspan="{{ count($lower_limit_sonne_commissions) > 0 ? count($lower_limit_sonne_commissions) : '' }}" class="text-center">-</td>
                            <td rowspan="{{ count($lower_limit_sonne_commissions) > 0 ? count($lower_limit_sonne_commissions) : '' }}" class="text-center">
                                <a class="btn {{ ($this->commissionSales($result?->id, 'dr-sonne')?->total_sales ?? 0) > 0 ? "btn-info" : "btn-secondary" }} btn-sm" style="{{ ($this->commissionSales($result?->id, 'dr-sonne')?->total_sales ?? 0) < 1 ? "pointer-events: none;" : "" }}" href="{{ route('roof.commission.detail', [$result?->id, $filter_month, 'dr-sonne']) }}" x-data="{ tooltip: 'Detail Komisi' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info fa-fw"></i></a>
                            </td>
                        </tr>
                        @if (count($lower_limit_sonne_commissions) > 0)
                            @foreach ($lower_limit_sonne_commissions as $key => $lower_limit_commission)
                                @if ($key > 0)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex">
                                                <div class="p-2">Rp. {{ number_format($lower_limit_commission?->target_payment, 0, ',', '.') }}</div>
                                                <div class="p-2">({{ $lower_limit_commission?->value }}%)</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @empty
                        <tr>
                            <td colspan="10" class="text-center fw-bold">Belum Ada Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <div class="row align-items-center g-3">
                <div class="col-lg-6 col-12">Menampilkan {{ $sales->firstItem() }} sampai {{ $sales->lastItem() }} dari {{ $sales->total() }} hasil</div>
                <div class="col-lg-6 col-12 text-align-end">{{ $sales->onEachSide(1)->links('vendor.livewire.custom-paginate') }}</div>
            </div>
        </div>
    </div>
</div>
