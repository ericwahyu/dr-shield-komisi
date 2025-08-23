@section('title', 'Komisi Atap')
<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div wire:loading.block wire:target="exportData">
        @include('layouts.layout.loading-screen')
    </div>
    @include('livewire.commission.roof-commission.roof-commission-export-modal')
    <div class="d-flex align-items-center">
        <div>
            <h3 class="mb-0 fw-semibold">Komisi Atap</h3>
        </div>
        <div class="ms-auto">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-export">Export Komisi <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></button>
        </div>
    </div>
    <hr class="my-3">
    <div class="nav-align-top mb-6">
        <ul class="nav nav-pills mb-4 gap-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#version-1" aria-controls="version-1" aria-selected="true">Versi 1</button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#version-2" aria-controls="version-2" aria-selected="false" tabindex="-1">Versi 2</button>
            </li>
            {{-- <li class="nav-item" role="presentation">
                <button type="button" class="nav-link waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#version-3" aria-controls="version-3" aria-selected="false" tabindex="-1">Messages</button>
            </li> --}}
        </ul>
        <div class="tab-content" style="border-radius: none; background: none; box-shadow: none; padding: 0rem">
            <div class="tab-pane fade" id="version-1" role="tabpanel">
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
                                        $row_span = 0;
                                        foreach ($categories as $key => $category) {
                                            $row_span += count($this->lowerLimiCommissions($result?->id, $category)) > 0 ? count($this->lowerLimiCommissions($result?->id, $category)) : 1;
                                        }
                                    @endphp
                                    <tr wire:key='{{ rand() }}'>
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
                                        <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($this->lowerLimiCommissions($result?->id, $categories[0])) : '' }}" class="text-center"><b>Dr Shield</b></td>
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
                                        <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $categories[0])) > 0 ? count($this->lowerLimiCommissions($result?->id, $categories[0])) : '' }}" class="text-center">
                                            <a class="btn {{ ($this->commissionSales($result?->id, $categories[0])?->total_sales ?? 0) > 0 ? "btn-info" : "btn-secondary" }} btn-sm" style="{{ ($this->commissionSales($result?->id, $categories[0])?->total_sales ?? 0) < 1 ? "pointer-events: none;" : "" }}" href="{{ route('roof.commission.detail.v1', [$result?->id, $filter_month, $categories[0]]) }}" x-data="{ tooltip: 'Detail Komisi' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info fa-fw"></i></a>
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
                                                <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $category)) > 0 ? count($this->lowerLimiCommissions($result?->id, $category)) : '' }}" class="text-center"><b>{{ $category?->name }}</b></td>
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
                                                <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $category)) > 0 ? count($this->lowerLimiCommissions($result?->id, $category)) : '' }}" class="text-center">{{ $this->commissionSales($result?->id, $category)?->value_commission ? "Rp. ". number_format($this->commissionSales($result?->id, $category)?->value_commission ?? 0, 0, ',', '.') : '-' }}</td>
                                                <td rowspan="{{ count($this->lowerLimiCommissions($result?->id, $category)) > 0 ? count($this->lowerLimiCommissions($result?->id, $category)) : '' }}" class="text-center">
                                                    <a class="btn {{ ($this->commissionSales($result?->id, $category)?->total_sales ?? 0) > 0 ? "btn-info" : "btn-secondary" }} btn-sm" style="{{ ($this->commissionSales($result?->id, $category)?->total_sales ?? 0) < 1 ? "pointer-events: none;" : "" }}" href="{{ route('roof.commission.detail.v1', [$result?->id, $filter_month, $category]) }}" x-data="{ tooltip: 'Detail Komisi' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info fa-fw"></i></a>
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
                        {{-- <div class="row align-items-center g-3">
                            <div class="col-lg-6 col-12">Menampilkan {{ $sales->firstItem() }} sampai {{ $sales->lastItem() }} dari {{ $sales->total() }} hasil</div>
                            <div class="col-lg-6 col-12 text-align-end">{{ $sales->onEachSide(1)->links('vendor.livewire.custom-paginate') }}</div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="version-2" role="tabpanel">
                <livewire:commission.roof-commission.roof-commission-v2.roof-commission-index-v2>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on("openModal", () => {
                jQuery('#modal').modal('show');
            });
            Livewire.on("closeModal", () => {
                jQuery('#modal').modal('hide');
            });
            Livewire.on("closeModal", () => {
                jQuery('#modal-export').modal('hide');
            });
        });
    </script>
@endpush
