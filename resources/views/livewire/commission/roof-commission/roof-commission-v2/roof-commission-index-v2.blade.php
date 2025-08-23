@php
    use App\Models\System\Category;
@endphp
<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
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
                        <input class="form-control" type="text" placeholder="Cari Sesuatu.." wire:model.debounce.xms="search">
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive scrollbar-x">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th rowspan = "2" class= "text-center" style = "width: 10px;">No</th>
                        <th rowspan = "2" class= "text-center">Nama Sales</th>
                        <th rowspan = "2" class = "text-center">NIK</th>
                        <th rowspan = "2" class = "text-center">Produk</th>
                        <th rowspan = "2" class = "text-center">Total Penjualan</th>
                        <th rowspan = "2" class = "text-center">Batas Bawah Target</th>
                        <th rowspan = "2" class = "text-center">Status</th>
                        <th colspan = "4" class = "text-center">Komisi</th>
                        <th rowspan = "2" class = "text-center" style = "width: 10px;">Aksi</th>
                    </tr>
                    <tr>
                        <th class="text-center">Rincian</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Admin 10 %</th>
                        <th class="text-center">Sales 90 %</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $result)
                        @php
                            $row_span = 0;
                            foreach ($categories as $key => $category) {
                                $row_span += count($this->lowerLimiCommissions($result?->id, $category)) > 0 ? count($this->lowerLimiCommissions($result?->id, $category)) : 1;
                                $total_commission = ($this->commissionSales($result?->id, $categories[0])?->value_commission + $this->commissionSales($result?->id, $categories[1])?->value_commission) + ($this->commissionSales($result?->id, $categories[0])?->add_on_commission + $this->commissionSales($result?->id, $categories[1])?->add_on_commission);
                            }
                            // dd($row_span);
                        @endphp
                        <tr wire:key='{{ rand() }}'>
                            {{-- <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" class="text-center">{{ $sales?->currentPage() * $perPage - $perPage + $loop->iteration }}</td> --}}
                            <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" class="text-center">{{ $loop->iteration }}</td>
                            <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" class="sorting_1">
                                <div class="d-flex justify-content-start align-items-center product-name">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-nowrap mb-0">{{ $result?->name ? $result?->name : '-' }}</h6>
                                        <small class="text-truncate d-none d-sm-block">{{ $result?->userDetail?->sales_code ? $result?->userDetail?->sales_code : '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" class="text-center">{{ $result?->userDetail?->civil_registration_number ? $result?->userDetail?->civil_registration_number : '-' }}</td>
                            <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($this->lowerLimiCommissions($result?->id, $categories[0])) : '' }}" class="text-center"><b>All</b></td>
                            <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($this->lowerLimiCommissions($result?->id, $categories[0])) : '' }}" class="text-center">{{ "Rp. ". number_format($this->commissionSales($result?->id, $categories[0])?->total_sales ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if (count($this->lowerLimiCommissions($result?->id, $categories[0])) > 0)
                                    <div class="d-flex">
                                        <div class="p-2">Rp. {{ number_format($this->lowerLimiCommissions($result?->id,  $categories[0])[0]?->target_payment, 0, ',', '.') }}</div>
                                        <div class="p-2">({{ $this->lowerLimiCommissions($result?->id, $categories[0])[0]?->value }}%)</div>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($this->lowerLimiCommissions($result?->id, $categories[0])) : '' }}" class="text-center">
                                @if ($this->commissionSales($result?->id, $categories[0]) != null)
                                    @if ($this->commissionSales($result?->id, $categories[0])?->status == 'reached')
                                        <span class="badge rounded-pill bg-success bg-glow">Mencapai Target</span>
                                    @else
                                        <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                                    @endif
                                @else
                                    <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                                @endif
                            </td>
                            <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($this->lowerLimiCommissions($result?->id, $categories[0])) : '' }}" class="text-center">{{ $this->commissionSales($result?->id, $categories[0])?->value_commission ? "Rp. ". number_format($this->commissionSales($result?->id, $categories[0])?->value_commission ?? 0, 0, ',', '.') : '-' }}</td>
                            <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" class="text-center">{{ $total_commission > 0 ? "Rp. ". number_format($total_commission ?? 0, 0, ',', '.') : '-'}}</td>
                            <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" class="text-center">{{ $total_commission > 0 ? "Rp. ". number_format($total_commission * 0.1 ?? 0, 0, ',', '.') : '-'}}</td>
                            <td rowspan="{{ $row_span > 0 ? $row_span : count($categories) }}" class="text-center">{{ $total_commission > 0 ? "Rp. ". number_format($total_commission * 0.9 ?? 0, 0, ',', '.') : '-'}}</td>
                            <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($this->lowerLimiCommissions($result?->id, $categories[0])) : '' }}" class="text-center">
                                <a class="btn {{ ($this->commissionSales($result?->id, $categories[0])?->total_sales ?? 0) > 0 ? "btn-info" : "btn-secondary" }} btn-sm" style="{{ ($this->commissionSales($result?->id, $categories[0])?->total_sales ?? 0) < 1 ? "pointer-events: none;" : "" }}" href="{{ route('roof.commission.detail.v2', [$result?->id, $filter_month, 'all']) }}" x-data="{ tooltip: 'Detail Komisi' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info fa-fw"></i></a>
                            </td>
                        </tr>
                        @if (count($this->lowerLimiCommissions($result?->id, $categories[0])) > 0)
                            @foreach ($this->lowerLimiCommissions($result?->id, $categories[0]) as $key => $lower_limit_commission)
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
                        @if (count($categories) > 0)
                            @foreach ($categories as $key => $category)
                                @if ($key == 0 )
                                    @continue
                                @endif
                                <tr>
                                    <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $category)) > 0 ? count($this->lowerLimiCommissions($result?->id, $category)) : '' }}"class="text-center"><b>Dr Sonne</b></td>
                                    <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $category)) > 0 ? count($this->lowerLimiCommissions($result?->id, $category)) : '' }}" class="text-center">{{ "Rp. ". number_format($this->commissionSales($result?->id, $category)?->total_sales ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if (count($this->lowerLimiCommissions($result?->id, $category)) > 0)
                                            <div class="d-flex">
                                                <div class="p-2">Rp. {{ number_format($this->lowerLimiCommissions($result?->id, $category)[0]?->target_payment, 0, ',', '.') }}</div>
                                                <div class="p-2">({{ $this->lowerLimiCommissions($result?->id, $category)[0]?->value }}%)</div>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $category)) > 0 ? count($this->lowerLimiCommissions($result?->id, $category)) : '' }}" class="text-center">
                                        @if ($this->commissionSales($result?->id, $category) != null)
                                            @if ($this->commissionSales($result?->id, $category)?->status == 'reached')
                                                <span class="badge rounded-pill bg-success bg-glow">Mencapai Target</span>
                                            @else
                                                <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                                            @endif
                                        @else
                                            <span class="badge rounded-pill bg-warning bg-glow">Tidak Mencapai Target</span>
                                        @endif
                                    </td>
                                    <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $category)) > 0 ? count($this->lowerLimiCommissions($result?->id, $category)) : '' }}" class="text-center">{{ $this->commissionSales($result?->id, $category)?->value_commission || $this->commissionSales($result?->id, $category)?->add_on_commission ? "Rp. ". number_format($this->commissionSales($result?->id, $category)?->value_commission + $this->commissionSales($result?->id, $category)?->add_on_commission  ?? 0, 0, ',', '.') : '-' }}</td>
                                    <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $category)) > 0 ? count($this->lowerLimiCommissions($result?->id, $category)) : '' }}" class="text-center">
                                        <a class="btn btn-secondary btn-sm" style="pointer-events: none;" href="{{ route('roof.commission.detail.v2', [$result?->id, $filter_month, $category]) }}" x-data="{ tooltip: 'Detail Komisi' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info fa-fw"></i></a>
                                    </td>
                                </tr>
                                @if (count($this->lowerLimiCommissions($result?->id, $category)) > 0)
                                    @foreach ($this->lowerLimiCommissions($result?->id, $category) as $key => $lower_limit_commission)
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
                {{-- <div class="col-lg-6 col-12">Menampilkan {{ $sales->firstItem() }} sampai {{ $sales->lastItem() }} dari {{ $sales->total() }} hasil</div>
                <div class="col-lg-6 col-12 text-align-end">{{ $sales->onEachSide(1)->links('vendor.livewire.custom-paginate') }}</div> --}}
            </div>
        </div>
    </div>
</div>
