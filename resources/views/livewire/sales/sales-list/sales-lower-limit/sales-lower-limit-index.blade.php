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
        <div class="nav-align-top mb-6">
            <ul class="nav nav-pills mb-4 gap-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#verison-1" aria-controls="verison-1" aria-selected="true">Versi 1</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#version-2" aria-controls="version-2" aria-selected="false" tabindex="-1">Versi 2</button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages" aria-selected="false" tabindex="-1">Messages</button>
                </li> --}}
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade" id="verison-1" role="tabpanel">
                    <div class="card-header d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0" style="text-align: center">Detail Batas Bawah Target</h5>
                        <button type="submit" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal">Tambah </button>
                    </div>
                    <div class="row">
                        @if (count($categories) < 1)
                            <div class="col-md-12">
                                <div class="table-responsive scrollbar-x">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 10px;">No</th>
                                                <th class="text-center">Nominal Target</th>
                                                <th class="text-center">Persentase</th>
                                                <th class="text-center" style="width: 10px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($this->getLowerLimits(null) as $result)
                                                <tr>
                                                    <td class = "text-center">{{ $loop->iteration }}</td>
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
                            @foreach ($categories as $categories)
                            <div class="col-md-6 mb-4">
                                <div class="mb-3 justify-content-between align-items-center">
                                    <h6 class="mb-0" style="text-align: center"><b>{{ $categories?->name }}</b></h6>
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
                                            @forelse ($this->getLowerLimits($categories?->slug) as $result)
                                                <tr>
                                                    <td class = "text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">
                                                        @if ($result?->category)
                                                            <b>{{ $result?->category?->name }}</b>
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
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade show active" id="version-2" role="tabpanel">
                    <livewire:sales.sales-list.sales-lower-limit-v2.sales-lower-limit-v2-index :id="$get_user?->id" wire:key="sales-lower-limit-v2-{{ $get_user?->id }}" />
                </div>
                <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
                    <p>
                        Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies cupcake gummi
                        bears
                        cake chocolate.
                    </p>
                    <p class="mb-0">
                        Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet roll icing
                        sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly jelly-o tart brownie
                        jelly.
                    </p>
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
