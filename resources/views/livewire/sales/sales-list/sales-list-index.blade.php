@section('title', 'Daftar Sales')
<div>
    {{-- Success is as dangerous as failure. --}}
    @include('livewire.sales.sales-list.sales-list-modal')
    <div class="d-flex align-items-center">
        <div>
            <h3 class="mb-0 fw-semibold">Daftar Sales</h3>
        </div>
        <div class="ms-auto">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">Tambah <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></button>
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
                <div class="col-12 col-lg-4">
                    <div class="row">
                        <div class="gap-2 col-lg-10 col-12 d-flex align-items-center">
                            {{-- <input class="form-control" type="date" wire:model.live="filter_date" id="html5-date-input"> --}}
                            <select class="form-select @error('type_filter') is-invalid @enderror" id="status" wire:model.live="type_filter" aria-label="Default select example">
                                <option value="" selected>-- Pilih Tipe Sales --</option>
                                <option value="ceramic" {{ $type_filter == 'ceramic' ? "selected" : "" }}>{{ Str::title('keramik') }}</option>
                                <option value="roof" {{ $type_filter == 'roof' ? "selected" : "" }}>{{ Str::title('atap') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 text-end">
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
                        <th class="text-center">Depo</th>
                        <th class="text-center">Tipe Sales</th>
                        <th class="text-center">Kode Sales</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 10px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $result)
                        {{-- @dd($result) --}}
                        <tr>
                            <td class="text-center">{{ $sales?->currentPage() * $perPage - $perPage + $loop->iteration }}</td>
                            <td class="text-center">{{ $result?->name ? $result?->name : '-' }}</td>
                            <td class="text-center">{{ $result?->userDetail?->civil_registration_number ? $result?->userDetail?->civil_registration_number : '-' }}</td>
                            <td class="text-center">{{ $result?->userDetail?->depo ? $result?->userDetail?->depo : '-' }}</td>
                            <td class="text-center">
                                @if ($result?->userDetail?->sales_type  == 'roof')
                                    <b>Atap</b>
                                @elseif ($result?->userDetail?->sales_type  == 'ceramic')
                                    <b>Keramik</b>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">{{ $result?->userDetail?->sales_code ? $result?->userDetail?->sales_code : '-' }}</td>
                            @if ($result->status == 'active')
                                <td class="text-center"><span class="badge rounded-pill bg-success bg-glow">Aktif</span></td>
                            @elseif ($result->status == 'non-active')
                                <td class="text-center"><span class="badge rounded-pill bg-secondary bg-glow">Non Aktif</span></td>
                            @else
                                <td class="text-center"><span class="badge rounded-pill bg-facebook bg-glow">N/A</span></td>
                            @endif
                            <td class="text-center">
                                @if ($result->status == 'active')
                                    <button class="btn btn-danger btn-sm" wire:click="deleteConfirm('{{ $result?->id }}')" x-data="{ tooltip: 'Nonaktifkan' }" x-tooltip="tooltip"><i class="fa-solid fa-trash-alt fa-fw"></i></button>
                                @elseif ($result->status == 'non-active')
                                    <button class="btn btn-success btn-sm" wire:click="activeConfirm('{{ $result?->id }}')" x-data="{ tooltip: 'Aktif' }" x-tooltip="tooltip"><i class="fa-solid fa-check fa-fw"></i></button>
                                @else
                                @endif
                                <button class="btn btn-warning btn-sm" wire:click="edit('{{ $result?->id }}')" x-data="{ tooltip: 'Edit' }" x-tooltip="tooltip"><i class="fa-solid fa-pencil-alt fa-fw"></i></button>
                                <a href="{{ route('sales.lower.limit', $result?->id) }}" class="btn btn-secondary btn-sm" x-data="{ tooltip: 'Setting Batas Bawah Target' }" x-tooltip="tooltip"><i class="fa-solid fa-gear fa-fw"></i></a>
                                {{-- @if ($result?->userDetail?->sales_type  == 'roof')
                                @endif --}}
                            </td>
                        </tr>
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
@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on("openModal", () => {
                jQuery('#modal').modal('show');
            });
            Livewire.on("closeModal", () => {
                jQuery('#modal').modal('hide');
            });
        });
    </script>
@endpush

