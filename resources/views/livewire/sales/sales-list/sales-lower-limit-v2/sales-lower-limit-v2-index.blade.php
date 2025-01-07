<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @include('livewire.sales.sales-list.sales-lower-limit-v2.sales-lower-limit-v2-modal')
    <div class="card-header d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0" style="text-align: center">Detail Batas Bawah Target</h5>
        <button type="submit" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-v2">Tambah </button>
    </div>
    <div class="row">
        @if ($get_user?->userDetail?->sales_type == 'ceramic')
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
            <div class="col-md-6 mb-4">
                <div class="mb-3 justify-content-between align-items-center">
                    <h6 class="mb-0" style="text-align: center"><b>ALL</b></h6>
                </div>
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
@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on("openModal-v2", () => {
                jQuery('#modal-v2').modal('show');
            });
            Livewire.on("closeModal", () => {
                jQuery('#modal-v2').modal('hide');
            });
        });
    </script>
@endpush
