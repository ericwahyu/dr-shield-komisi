@section('title', 'Detail Batas Bawah Target')
<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    @include('livewire.sales.sales-list.sales-lower-limit.sales-lower-limit-modal')
    <div wire:loading.block wire:target="saveData">
        {{-- @include('layouts.admin.loading-screen') --}}
    </div>
    <div class="d-flex align-items-center">
        <a href="{{ route('sales.list') }}" class="btn btn-icon" style="margin-right: 15px"><i class="fa-solid fa-arrow-left"></i></a>
        <div>
            <h3 class="mb-0 fw-semibold">Detail Batas Bawah Target</h3>
        </div>
    </div>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-4 card">
                {{-- <h5 class="card-header d-flex justify-content-between align-items-center">Data Akun Admin</h5> --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="text-align: center">Data Sales</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-3">
                            <div class="form-label">Nama Sales</div>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.live="name" placeholder="" disabled>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <div class="form-label">Kode Sales</div>
                            <input type="text" class="form-control @error('sales_code') is-invalid @enderror" wire:model="sales_code" placeholder="" disabled>
                            @error('sales_code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <div class="form-label">NIK</div>
                            <input type="text" class="form-control @error('civil_registration_number') is-invalid @enderror" wire:model.live="civil_registration_number" placeholder="" disabled>
                            @error('civil_registration_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <div class="form-label">Tipe Sales</div>
                            <input type="text" class="form-control @error('sales_type') is-invalid @enderror" wire:model="sales_type" min="0" placeholder="" disabled>
                            @error('sales_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-4 card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="text-align: center">Detail Batas Bawah Target</h5>
                    <button type="submit" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal">Tambah </button>
                </div>
                {{-- <div class="mb-0 card-body">
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
                                    <input class="form-control" type="date" wire:model.live="filter_date" id="html5-date-input">
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
                </div> --}}
                <div class="row">
                    @if ($get_user?->userDetail?->sales_type == 'ceramic')
                        <div class="col-md-12">
                            <div class="table-responsive scrollbar-x">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 10px;">No</th>
                                            {{-- <th class="text-center">Tipe</th> --}}
                                            <th class="text-center">Nominal Target</th>
                                            <th class="text-center">Persentase</th>
                                            <th class="text-center" style="width: 10px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($ceramic_lower_limits as $result)
                                            <tr>
                                                <td class = "text-center">{{ $loop->iteration }}</td>
                                                {{-- <td class="text-center">
                                                    @if ($result?->type  == 'dr-shield')
                                                        <b>Dr Shield</b>
                                                    @elseif ($result?->type  == 'dr-sonne')
                                                        <b>Dr Sonne</b>
                                                    @elseif ($result?->type  == 'ceramic')
                                                        <b>Keramik</b>
                                                    @else
                                                        -
                                                    @endif
                                                </td> --}}
                                                <td class = "text-center">{{ $result?->target_payment ? "Rp. ". number_format($result?->target_payment, 0, ',', '.') : '-' }}</td>
                                                <td class = "text-center">{{ $result?->value ? $result?->value : '-' }}</td>
                                                <td class = "text-center">
                                                <button class = "btn btn-danger btn-sm" wire:click  = "deleteConfirm('{{ $result?->id }}')" x-data = "{ tooltip: 'Hapus' }" x-tooltip = "tooltip"><i class = "fa-solid fa-trash-alt fa-fw"></i></button>
                                                <button class = "btn btn-warning btn-sm" wire:click = "edit('{{ $result?->id }}')" x-data          = "{ tooltip: 'Edit' }" x-tooltip  = "tooltip"><i class = "fa-solid fa-pencil-alt fa-fw"></i></button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center fw-bold">Belum Ada Data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="col-md-6">
                            <div class="mb-3 justify-content-between align-items-center">
                                <h6 class="mb-0" style="text-align: center"><b>Dr Shield</b></h6>
                                {{-- <button type="submit" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal">Tambah </button> --}}
                            </div>
                            <div class="table-responsive scrollbar-x">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 10px;">No</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Nominal Target</th>
                                            <th class="text-center">Persentase</th>
                                            <th class="text-center" style="width: 10px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dr_shield_lower_limits as $result)
                                            <tr>
                                                <td class = "text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    @if ($result?->category  == 'dr-shield')
                                                        <b>Dr Shield</b>
                                                    @elseif ($result?->category  == 'dr-sonne')
                                                        <b>Dr Sonne</b>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class = "text-center">{{ $result?->target_payment ? "Rp. ". number_format($result?->target_payment, 0, ',', '.') : '-' }}</td>
                                                <td class = "text-center">{{ $result?->value ? $result?->value : '-' }}</td>
                                                <td class = "text-center">
                                                <button class = "btn btn-danger btn-sm" wire:click  = "deleteConfirm('{{ $result?->id }}')" x-data = "{ tooltip: 'Hapus' }" x-tooltip = "tooltip"><i class = "fa-solid fa-trash-alt fa-fw"></i></button>
                                                <button class = "btn btn-warning btn-sm" wire:click = "edit('{{ $result?->id }}')" x-data          = "{ tooltip: 'Edit' }" x-tooltip  = "tooltip"><i class = "fa-solid fa-pencil-alt fa-fw"></i></button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center fw-bold">Belum Ada Data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 justify-content-between align-items-center">
                                <h6 class="mb-0" style="text-align: center"><b>Dr Sonne</b></h6>
                                {{-- <button type="submit" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal">Tambah </button> --}}
                            </div>
                            <div class="table-responsive scrollbar-x">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 10px;">No</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Nominal Target</th>
                                            <th class="text-center">Persentase</th>
                                            <th class="text-center" style="width: 10px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dr_sonne_lower_limits as $result)
                                            <tr>
                                                <td class = "text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    @if ($result?->category  == 'dr-shield')
                                                        <b>Dr Shield</b>
                                                    @elseif ($result?->category  == 'dr-sonne')
                                                        <b>Dr Sonne</b>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class = "text-center">{{ $result?->target_payment ? "Rp. ". number_format($result?->target_payment, 0, ',', '.') : '-' }}</td>
                                                <td class = "text-center">{{ $result?->value ? $result?->value : '-' }}</td>
                                                <td class = "text-center">
                                                <button class = "btn btn-danger btn-sm" wire:click  = "deleteConfirm('{{ $result?->id }}')" x-data = "{ tooltip: 'Hapus' }" x-tooltip = "tooltip"><i class = "fa-solid fa-trash-alt fa-fw"></i></button>
                                                <button class = "btn btn-warning btn-sm" wire:click = "edit('{{ $result?->id }}')" x-data          = "{ tooltip: 'Edit' }" x-tooltip  = "tooltip"><i class = "fa-solid fa-pencil-alt fa-fw"></i></button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center fw-bold">Belum Ada Data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row align-items-center g-3">
                        {{-- <div class="col-lg-6 col-12">Menampilkan {{ $ceramic_invoices->firstItem() }} sampai {{ $ceramic_invoices->lastItem() }} dari {{ $ceramic_invoices->total() }} hasil</div>
                        <div class="col-lg-6 col-12 text-align-end">{{ $ceramic_invoices->onEachSide(1)->links('vendor.livewire.custom-paginate') }}</div> --}}
                    </div>
                </div>
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
